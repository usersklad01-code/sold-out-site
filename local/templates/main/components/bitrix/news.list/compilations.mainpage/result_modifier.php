<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** ***********************************************************************
 * Предобработка данных - получение информации о продуктах
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * ************************************************************************/

// все торговые продложения всех списков
$ids = [];
foreach ($arResult['ITEMS'] as $item) {
	foreach ($item['PROPERTIES']['ELEMENTS']['VALUE'] as $id) {
		$ids[$id] = true;
	}
}

// список торговых предложений (продуктов)
$products = [];
$offers = [];
if (count($ids) > 0) {
	$dbRes = \CIBlockElement::GetList(
		array(),
		array(
			'IBLOCK_ID' => IB_OFFERS,
			'ACTIVE' => 'Y',
			'ID' => array_keys($ids)
		),
		false,
		false,
		['*', 'CATALOG_AVAILABLE', 'PROPERTY_CML2_LINK']
	);

	while ($item = $dbRes->GetNext()) {
		$products[$item['PROPERTY_CML2_LINK_VALUE']] = true;
		$item['PRICE'] = \CCatalogProduct::GetOptimalPrice($item['ID']);
		$offers[$item['ID']] = $item;
	}
}

// список самих товаров
if (count($products) > 0) {
	$dbRes = \CIBlockElement::GetList(
		array(),
		array(
			'IBLOCK_ID' => IB_CATALOG,
			'ACTIVE' => 'Y',
			'ID' => array_keys($products)
		));

	while ($item = $dbRes->Fetch()) {
		$products[$item['ID']] = $item;
	}
}

// раскладываем все по спискам
foreach ($arResult['ITEMS'] as &$item) {
	foreach ($item['PROPERTIES']['ELEMENTS']['VALUE'] as $id) {
		if (!!$offers[$id]) {
			$offers[$id]['PRODUCT'] = $products[$offers[$id]['PROPERTY_CML2_LINK_VALUE']];
			$item['ELEMENTS'][] = $offers[$id];
		}
	}
}
unset ($item);