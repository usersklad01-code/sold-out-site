<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** *************************************************************************
 * Блок с подборками товаров
 * @var array $arParams
 * @global \CMain $APPLICATION
 * **************************************************************************/

$GLOBALS["arrCompilationFilter"] = $arParams['FILTER'];
$APPLICATION->IncludeComponent(
    "cake:catalog.offers.list",
    "products.slider",
    array(
        "IBLOCK_CATALOG_ID" => IB_CATALOG,
        "IBLOCK_OFFERS_ID" => IB_OFFERS,
        "HIDE_NOT_AVAILABLE" => 'Y',
        "HIDE_NOT_AVAILABLE_OFFERS" => 'Y',
        "SECTION_ID" => $arParams['SECTION_ID'],
        "SECTION_CODE" => '',
        "INCLUDE_SUBSECTIONS" => 'Y',
        "SECTION_PAGE_URL" =>'/catalog/#SECTION_CODE_PATH#/',
        "DETAIL_PAGE_URL" => '/catalog/#SECTION_CODE_PATH#/#OFFER_CODE#/',
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "N",
        "FILTER_NAME" => "arrCompilationFilter",
        "SORT_BY" => is_array($arParams['SORT']) ? key($arParams['SORT']) : 'ID',
        "SORT_ORDER" => is_array($arParams['SORT']) ? current($arParams['SORT']) : 'DESC',
        "SORT_BY2" => "RAND",
        "SORT_ORDER2" => "ASC",
        "ITEM_COUNT" => 10,
        "ADD_SECTIONS_CHAIN" => "N",
		"PROPERTIES" => ["RATING_AVG", "RATING_CNT"],
		'TITLE' => $arParams['TITLE']
    ),
    isset($this) ? $this->getComponent() : false,
    array('HIDE_ICONS' => 'Y')
);
