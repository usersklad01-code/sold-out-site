<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** *************************************************************************
 * Разводящая каталога - список секций первого уровня
 * @var array $arParam
 * @var array $arResult
 * @global \CMain $APPLICATION
 * **************************************************************************/
$this->setFrameMode(true); ?>

<main class="catalog-page">
	<div class="container">
		<h1 class="page-title page-title--1"><?= $APPLICATION->ShowTitle(false) ?></h1>
		<? $APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			"catalog.mainpage",
			array(
				"ADDITIONAL_COUNT_ELEMENTS_FILTER" => "",
				"ADD_SECTIONS_CHAIN" => "N",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "N",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"COUNT_ELEMENTS" => "N",
				"COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
				"FILTER_NAME" => "arrSectionsFilter",
				"HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "N",
				"IBLOCK_ID" => IB_CATALOG,
				"IBLOCK_TYPE" => TYPE_IB_CATALOG,
				"SECTION_CODE" => "",
				"SECTION_FIELDS" => array("NAME", "PICTURE"),
				"SECTION_ID" => '',
				"SECTION_URL" => "",
				"SECTION_USER_FIELDS" => array(),
				"SHOW_PARENT_NAME" => "Y",
				"TOP_DEPTH" => "1",
				"VIEW_MODE" => "LINE"
			),
			false,
			array('HIDE_ICONS' => 'Y')
		); ?>
	</div>
</main>