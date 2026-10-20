<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***********************************************************************
 * Корректировка полей
 * @var array $arParams
 * @var array $arResult
 * ************************************************************************/

// картинка
if ($arResult["ITEM"]['PREVIEW_PICTURE']) {
	$arResult["ITEM"]['PREVIEW_PICTURE'] = \CFile::ResizeImageGet($arResult["ITEM"]['PREVIEW_PICTURE'], array("width" => 378, "height" => 220), BX_RESIZE_IMAGE_PROPORTIONAL, false);
} elseif ($arResult["PRODUCT"]['PREVIEW_PICTURE']) {
	$arResult["ITEM"]['PREVIEW_PICTURE'] = CFile::ResizeImageGet($arResult["PRODUCT"]['PREVIEW_PICTURE'], array("width" => 378, "height" => 220), BX_RESIZE_IMAGE_PROPORTIONAL, false);
} else {
	$arResult["ITEM"]['PREVIEW_PICTURE'] = array("src" => SITE_TEMPLATE_PATH . "/tpl/assets/img/no-photo.svg");
}

// ссылка
if(!empty($arResult["SECTION"])){
	$arResult['ITEM']['DETAIL_PAGE_URL'] = "/catalog" . $arResult["SECTION"]["PATH"] . "/" . ($arResult["ITEM"]['CODE'] ?: $arResult["ITEM"]['ID']) . "/";
} else {
	 if($arResult["ITEM"]['PRODUCT_ID']) {
		$resSec = CIBlockElement::GetList([], ["IBLOCK_ID" => IB_CATALOG, "ACTIVE" => "Y", "ID" => $arResult["ITEM"]['PRODUCT_ID']], false, false, ["ID", "IBLOCK_ID", "NAME", "CODE"]);
		while($ob = $resSec->GetNextElement()) {
			$arFields = $ob->GetFields();
			$arResult['ITEM']['PRODUCT_CODE'] = $arFields['CODE'];
		}

		$arResult['ITEM']['DETAIL_PAGE_URL'] = str_replace($arResult['ITEM']['PRODUCT_CODE'], $arResult['ITEM']['CODE'], $arResult['ITEM']['DETAIL_PAGE_URL']);
	}
}

// форматирование цены
$arResult["ITEM"]["PRICE"]["RESULT_PRICE"]["DISCOUNT_PRICE_PRINT"] = number_format(
	$arResult['ITEM']['MIN_PRICE']['DISCOUNT_VALUE'] ?: $arResult["ITEM"]["PRICE"]["RESULT_PRICE"]["DISCOUNT_PRICE"],
	0, '.', ' '
);
$arResult["ITEM"]["PRICE"]["RESULT_PRICE"]["DISCOUNT_PRINT"] = number_format(
	$arResult['ITEM']['MIN_PRICE']['DISCOUNT_VATRATE_VALUE'] ?: $arResult["ITEM"]["PRICE"]["RESULT_PRICE"]["DISCOUNT"],
	0, '.', ' '
);
