<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$count = 0;
if (!empty($arResult["NAV_RESULT"])) {
	$count = $arResult["NAV_RESULT"]->SelectedRowsCount();
}
$query = $arResult['REQUEST']['QUERY'];

?>
<main class="search">
	<div class="container">
		<h1 class="page-title page-title--1">Результаты для поиска «<?= $query ?>»</h1>

		<? if (isset($arResult["REQUEST"]["ORIGINAL_QUERY"])) { ?>
			<div class="search-language-guess">
				<? echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#" => '<a href="' . $arResult["ORIGINAL_QUERY_URL"] . '">' . $arResult["REQUEST"]["ORIGINAL_QUERY"] . '</a>')) ?>
			</div>
		<? } ?>



		<? if ($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false) { ?>
		<? } elseif ($arResult["ERROR_CODE"] != 0) { ?>

			<p><?= GetMessage("SEARCH_ERROR") ?></p>
			<? ShowError($arResult["ERROR_TEXT"]); ?>
			<p><?= GetMessage("SEARCH_CORRECT_AND_CONTINUE") ?></p>
			<br/><br/>
			<p><?= GetMessage("SEARCH_SINTAX") ?><br/><b><?= GetMessage("SEARCH_LOGIC") ?></b></p>
			<table border="0" cellpadding="5">
				<tr>
					<td align="center" valign="top"><?= GetMessage("SEARCH_OPERATOR") ?></td>
					<td valign="top"><?= GetMessage("SEARCH_SYNONIM") ?></td>
					<td><?= GetMessage("SEARCH_DESCRIPTION") ?></td>
				</tr>
				<tr>
					<td align="center" valign="top"><?= GetMessage("SEARCH_AND") ?></td>
					<td valign="top">and, &amp;, +</td>
					<td><?= GetMessage("SEARCH_AND_ALT") ?></td>
				</tr>
				<tr>
					<td align="center" valign="top"><?= GetMessage("SEARCH_OR") ?></td>
					<td valign="top">or, |</td>
					<td><?= GetMessage("SEARCH_OR_ALT") ?></td>
				</tr>
				<tr>
					<td align="center" valign="top"><?= GetMessage("SEARCH_NOT") ?></td>
					<td valign="top">not, ~</td>
					<td><?= GetMessage("SEARCH_NOT_ALT") ?></td>
				</tr>
				<tr>
					<td align="center" valign="top">( )</td>
					<td valign="top">&nbsp;</td>
					<td><?= GetMessage("SEARCH_BRACKETS_ALT") ?></td>
				</tr>
			</table>

		<? } elseif (count($arResult["SEARCH"]) > 0) { ?>


			<?
			// Фильтр по найденным товарам
			$skuIds = array_column($arResult["SEARCH"], 'ITEM_ID');
			$GLOBALS['searchFilter'] = array(
				'SECTION_ACTIVE' => 'Y',
				'SECTION_GLOBAL_ACTIVE' => 'Y',
				'OFFERS' => ['ID' => $skuIds]
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
					"HIDE_NOT_AVAILABLE" => 'Y',
					"HIDE_NOT_AVAILABLE_OFFERS" => 'Y',
					"SECTION_ID" => '',
					"SECTION_CODE" => '',
					"INCLUDE_SUBSECTIONS" => 'Y',
					"SECTION_PAGE_URL" => '/catalog/#SECTION_CODE_PATH#/',
					"DETAIL_PAGE_URL" => '/catalog/#SECTION_CODE_PATH#/#OFFER_CODE#/',
					"CACHE_TYPE" => 'A',
					"CACHE_TIME" => 360000,
					"CACHE_FILTER" => 'Y',
					"CACHE_GROUPS" => 'N',
					"FILTER_NAME" => 'searchFilter',
					"SORT_VARIANTS" => $arSort,
					"SORT_BY" => $arSort[$sort]['FIELD'],
					"SORT_ORDER" => $arSort[$sort]['ORDER'],
					"SORT_BY2" => 'SORT',
					"SORT_ORDER2" => 'ASC',
					"ITEM_COUNT" => 15,
					"ADD_SECTIONS_CHAIN" => "N",
					"VIEW_SWITCHER" => $request->getCookie('CATALOG_VIEW') ?: 'grid-view',
					"PROPERTIES" => ["RATING_AVG", "RATING_CNT"],
					"HIDE_FILTER_BTN" => 'Y'
				),
				$this->getComponent()
			); ?>


		<? } else { ?>

			<? ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND")); ?>
		<? } ?>



		<? $APPLICATION->IncludeComponent(
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
			false,
			array('HIDE_ICONS' => 'N')
		); ?>
	</div>
</main>
