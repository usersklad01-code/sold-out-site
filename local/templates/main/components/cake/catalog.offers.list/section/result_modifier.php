<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** **************************************************************************
 * Предобработка параметров
 * @var array $arParams
 * @var array $arResult
 * ***************************************************************************/

// Получить ссылку (в некоторых случаях передается в параметрах, в других - нужно вычислить)
$sectionUrl = $arParams['SECTION_PAGE_URL'];
if (!$sectionUrl) {
	$sectionUrl = \Bitrix\Iblock\IblockTable::query()
		->setSelect(["SECTION_PAGE_URL"])
		->where("ID", "=", $arResult["ITEMS"][0]["IBLOCK_ID"])
		->exec()
		->fetch();
	$sectionUrl = $sectionUrl['SECTION_PAGE_URL'];
}
$arResult["SECTION"]["SECTION_PAGE_URL"] =  \CIBlock::ReplaceDetailUrl($sectionUrl, $arResult["SECTION"], false, 'S');