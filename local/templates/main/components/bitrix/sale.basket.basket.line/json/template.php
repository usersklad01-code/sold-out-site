<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** ***********************************************************************
 * Вовзвращает корзину в json формате
 * @var array $arParams
 * @var array $arResult
 * ************************************************************************/

$basketItems = [];
foreach ($arResult["CATEGORIES"] as $category => $items) {
	foreach ($items as $item) {
		$basketItems[] = array(
			'id' => $item['ID'],
			'name' => $item['NAME'],
			'url' => $item['DETAIL_PAGE_URL'],
			'price' => $item['PRICE_FMT'],
			'priceOld' => $item["FULL_PRICE"] != $item["PRICE_FMT"] ? $item['FULL_PRICE'] . '₽' : '',
		);
	}
}

echo \Bitrix\Main\Web\Json::encode(array(
	'basketItems' =>  $basketItems
));