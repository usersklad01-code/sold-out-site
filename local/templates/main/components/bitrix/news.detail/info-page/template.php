<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Информационная страница
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * ***************************************************************************/
$this->setFrameMode(false); ?>
<div class="container">
<div class="breadcrumbs">
    <ul class="breadcrumbs__list" itemscope itemtype="http://schema.org/BreadcrumbList">
    <li class="breadcrumbs__link-after" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
        <a class="breadcrumbs__link" itemprop="item" href="/" title="Главная">
            <span itemprop="name">Главная</span>
        </a>
        <meta itemprop="position" content="1">
    </li>

    <li class="breadcrumbs__link-after" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
        <span class="breadcrumbs__link" itemprop="item"><span itemprop="name"><?=$arResult['NAME']?></span>
        </span><meta itemprop="position" content="2">
    </li>
    </ul>
</div>
</div>
<main class="news-page">
    <div class="container">
        <div class="content-wrap">
			<?php

			// Текст самой стать ?>
			<div><?= $arResult['~DETAIL_TEXT']?></div>
			<?php

			// Баннер в конце статьи
			if ($arResult['PROPERTIES']['SLIDER']['VALUE'] != null) {
				$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => SITE_TEMPLATE_PATH . "/include_areas/banner/big-slider.php",
					"SECTION_ID" => $arResult['PROPERTIES']['SLIDER']['VALUE'],
					"WRAPPER" => "sec-main-slider"
				));
			}

			// FAQ
			if ($arResult['PROPERTIES']['FAQ']['VALUE'] != null) {
				$APPLICATION->IncludeComponent(
					"bitrix:news.list",
					"faq-list",
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
						"FIELD_CODE" => array(0 => "NAME", 1 => "PREVIEW_TEXT", 2 => "",),
						"FILTER_NAME" => "",
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",
						"IBLOCK_ID" => IB_FAQ,
						"IBLOCK_TYPE" => TYPE_IB_CONTENT,
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"INCLUDE_SUBSECTIONS" => "N",
						"MESSAGE_404" => "",
						"NEWS_COUNT" => "20",
						"PAGER_BASE_LINK_ENABLE" => "N",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "N",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_TEMPLATE" => "",
						"PAGER_TITLE" => "",
						"PARENT_SECTION" => $arResult['PROPERTIES']['FAQ']['VALUE'],
						"PARENT_SECTION_CODE" => "",
						"PREVIEW_TRUNCATE_LEN" => "",
						"PROPERTY_CODE" => array(0 => "", 1 => "",),
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
				);
			} ?>
        </div>
    </div>
</main>
