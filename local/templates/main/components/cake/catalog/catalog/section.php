<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** *************************************************************************
 * Список товаров
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * **************************************************************************/
$this->setFrameMode(true);

// название, описание текущей секции и родительская секция
if ($arResult['VARIABLES']['SECTION_ID'] > 0) {
	$curSec = \Bitrix\Iblock\SectionTable::query()
		->setSelect(['ID', 'NAME', 'DESCRIPTION', 'IBLOCK_SECTION_ID'])
		->where('ID', '=', $arResult['VARIABLES']['SECTION_ID'])
		->exec()
		->fetch();
	if (!!$curSec) {
		$arResult['VARIABLES']['SECTION_NAME'] = $curSec['NAME'];
		$arResult['VARIABLES']['PARENT_SECTION_ID'] = $curSec['IBLOCK_SECTION_ID'];
		if (!empty($curSec['DESCRIPTION'])) {
			$APPLICATION->SetPageProperty("seotext", $curSec['DESCRIPTION']);
		}
	}
}

// Страница списка товаров ?>
<main class="catalog-page">
    <div class="container">
        <h1 class="page-title page-title--1"><?= $arResult['VARIABLES']['SECTION_NAME'] ?></h1>
		<?php

		// Тегов/подразделы текущего раздела каталога
		$cnt = $APPLICATION->IncludeComponent(
			"cake:catalog.tags",
			"tags",
			array(
				"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
				"IBLOCK_ID" => $arParams['IBLOCK_ID'],
				"SECTION_ID" => $arResult['VARIABLES']['SECTION_ID'],
				"TAG_FIELD_CODE" => "UF_TAGS",
				"GET_CHILD_ITEMS" => 'N',
				"CUR_DIR" => $APPLICATION->GetCurDir(),
				"CACHE_TYPE" => $arParams['CACHE_TYPE'],
				"CACHE_TIME" => $arParams['CACHE_TIME'],
				"SEF_URL_TEMPLATES" => array(
					'base' => '/catalog/',
					'section' => $arResult["URL_TEMPLATES"]["section"],
					'element' => $arResult["URL_TEMPLATES"]["element"],
				),
			),
			$this->getComponent()
		);

		// Если в текущем каталоге тегов нет - выводим из родительского раздела
		if ($cnt == 0 && $arResult['VARIABLES']['PARENT_SECTION_ID'] > 0) {
			$APPLICATION->IncludeComponent(
				"cake:catalog.tags",
				"tags",
				array(
					"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
					"IBLOCK_ID" => $arParams['IBLOCK_ID'],
					"SECTION_ID" => $arResult['VARIABLES']['PARENT_SECTION_ID'],
					"TAG_FIELD_CODE" => "UF_TAGS",
					"GET_CHILD_ITEMS" => 'N',
					"CUR_DIR" => $APPLICATION->GetCurDir(),
					"CACHE_TYPE" => $arParams['CACHE_TYPE'],
					"CACHE_TIME" => $arParams['CACHE_TIME'],
					"SEF_URL_TEMPLATES" => array(
						'base' => '/catalog/',
						'section' => $arResult["URL_TEMPLATES"]["section"],
						'element' => $arResult["URL_TEMPLATES"]["element"],
					),
				),
				$this->getComponent()
			);
		}

		// Фильтр и список товаров ?>
		<div class="sec-products-catalog" id="catalog-section">
			<?php

			// Фильтр
			$APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter",
				"catalog",
				array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => $arResult['VARIABLES']['SECTION_ID'] ?: $arParams["SECTION_ID"],
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SAVE_IN_SESSION" => "N",
					"FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
					"XML_EXPORT" => "Y",
					"SECTION_TITLE" => "NAME",
					"SECTION_DESCRIPTION" => "DESCRIPTION",
					'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
					"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
					"SEF_MODE" => "N",
					"SEF_RULE" => ($arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["smart_filter"]) ?: '/catalog/#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/',
					"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
					"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
					"INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
					'AJAX_REQUEST' => $arParams['AJAX_REQUEST'],
					'DISPLAY_ELEMENT_COUNT' => "Y",
					"SEF_URL_TEMPLATES" => array(
						'base' => '/catalog/',
						'section' => $arResult['VARIABLES']['SECTION_CODE_PATH'] ?: $arParams['SEF_URL_TEMPLATES']['section'],
					),
				),
				$this->getComponent()
			);

			// Сортировка
			$arSort = array(
				'price-asc' => ['FIELD' => 'CATALOG_PRICE_1', 'ORDER' => 'asc', 'NAME' => 'Цена по возрастанию'],
				'price-desc' => ['FIELD' => 'CATALOG_PRICE_1', 'ORDER' => 'desc', 'NAME' => 'Цена по убыванию'],
				'popularity' => ['FIELD' => 'SORT', 'ORDER' => 'asc', 'NAME' => 'Самые популярные'],
			);

			$request = \Bitrix\Main\Context::getCurrent()->getRequest();
			$sort = $request->getCookie('CATALOG_SORT');
			if (!$arSort[$sort]) {
				$sort = key($arSort);
			}
			$arSort[$sort]['CHECKED'] = true;

			// Список товаров
			$APPLICATION->IncludeComponent(
				"cake:catalog.offers.list",
				"section",
				array(
					"IBLOCK_CATALOG_ID" => IB_CATALOG,
					"IBLOCK_OFFERS_ID" => IB_OFFERS,
					"HIDE_NOT_AVAILABLE" => $arParams['HIDE_NOT_AVAILABLE'],
					"HIDE_NOT_AVAILABLE_OFFERS" => $arParams['HIDE_NOT_AVAILABLE_OFFERS'],
					"SECTION_ID" => $arResult['VARIABLES']['SECTION_ID'],
					"SECTION_CODE" => $arResult['VARIABLES']['SECTION_CODE'],
					"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
					"SECTION_PAGE_URL" => ($arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"]) ?: '/catalog/#SECTION_CODE_PATH#/',
					"DETAIL_PAGE_URL" => ($arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["offer"]) ?: '/catalog/#SECTION_CODE_PATH#/#OFFER_CODE#/',
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_FILTER" => $arParams["CACHE_FILTER"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"SORT_VARIANTS" => $arSort,
					"SORT_BY" => $arSort[$sort]['FIELD'],
					"SORT_ORDER" => $arSort[$sort]['ORDER'],
					"SORT_BY2" => 'SORT',
					"SORT_ORDER2" => 'ASC',
					"ITEM_COUNT" => 15,
					"ADD_SECTIONS_CHAIN" => "Y",
					"VIEW_SWITCHER" => $request->getCookie('CATALOG_VIEW') ?: 'grid-view',
					"PROPERTIES" => ["RATING_AVG", "RATING_CNT"]
				),
				$this->getComponent()
			); ?>
		</div>
		<?php

		// Блок преимуществ (как на главной)
		$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"main-advantages-list",
			array(
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"ADD_SECTIONS_CHAIN" => "N",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "N",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"CHECK_DATES" => "Y",
				"DETAIL_URL" => "",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"DISPLAY_DATE" => "N",
				"DISPLAY_NAME" => "N",
				"DISPLAY_PICTURE" => "N",
				"DISPLAY_PREVIEW_TEXT" => "N",
				"DISPLAY_TOP_PAGER" => "N",
				"FIELD_CODE" => array(0 => "NAME"),
				"FILTER_NAME" => "arrMainAdvantagesFilter",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"IBLOCK_ID" => IB_ADVANTAGES,
				"IBLOCK_TYPE" => TYPE_IB_CONTENT,
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"INCLUDE_SUBSECTIONS" => "N",
				"MESSAGE_404" => "",
				"NEWS_COUNT" => "3",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => "",
				"PAGER_TITLE" => "",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"PREVIEW_TRUNCATE_LEN" => "",
				"PROPERTY_CODE" => array(0 => "ICON", 1 => 'LINK'),
				"SET_BROWSER_TITLE" => "N",
				"SET_LAST_MODIFIED" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "N",
				"SHOW_404" => "N",
				"SORT_BY1" => "SORT",
				"SORT_BY2" => "SORT",
				"SORT_ORDER1" => "ASC",
				"SORT_ORDER2" => "ASC",
				"STRICT_SECTION_CHECK" => "N"
			),
			$this->getComponent()
		);?>

		<?php

		// Запоминаем параметры для js
		$arParams["TEMPLATE"] = 'catalog-section';
		$arParams["VARIABLES_SECTION_CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
		$arParams["FOLDER_URL_TEMPLATES_section"] = $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"];
		$arParams["FOLDER_URL_TEMPLATES_element"] = $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"];
		$arParams["IBLOCK_URL"] = $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"];
		$arParams["REQUEST_URI"] = $_SERVER["REQUEST_URI"];
		$arParams["SCRIPT_NAME"] = $_SERVER["SCRIPT_NAME"]; ?>
		<script>
			var component_arParams = <?echo CUtil::PhpToJSObject($arParams)?>;
		</script>
	</div>
    <?php

	// SEO-текст раздела
    $seoText = $APPLICATION->GetProperty("seotext");
    if (strlen($seoText) > 0) { ?>
        <div class="container ">
            <div class="content-wrap block-news-wrap">
                <div class="block-news">
                    <div class="block-news__container"><?= $seoText ?></div>
                    <button class="js-block-news-more">Показать ещё</button>
                </div>
            </div>
        </div>
    <? } ?>
</main>