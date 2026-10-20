<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** ***********************************************************************
 * Предобработка данных для страницы сравнения
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * ************************************************************************/

// для sku извлекаем дополнительно цену и основной продукт
$ids = [];
foreach ($arResult['ITEMS'] as &$item) {
	$ids[] = $item['ID'];
	$item['PRODUCT_ID'] = CCatalogSku::GetProductInfo($item['ID']);
	$item['PRICE'] = \CCatalogProduct::GetOptimalPrice($item['ID']);
}
unset($item);

// список свойств, которые отмечены галочкой, что они используются для деталки
$arPropIds = \Bitrix\Iblock\Model\PropertyFeature::getDetailPageShowPropertyCodes($arParams['IBLOCK_ID']);
$dbRes = \Bitrix\Iblock\PropertyTable::query()
	->setSelect(['ID', 'NAME', 'CODE', 'PROPERTY_TYPE'])
	->whereIn('ID', $arPropIds)
	->where('ACTIVE', '=', 'Y')
	->exec();

$arPropTable = [];
while($item = $dbRes->fetch()) {
	$arPropTable[$item['ID']] = $item;
}

// заполненные свойства у выбранных для сравнения товаров
$dbRes = \Bitrix\Iblock\ElementPropertyTable::query()
	->setSelect(['IBLOCK_PROPERTY_ID', 'IBLOCK_ELEMENT_ID', 'VALUE'])
	->whereIn('IBLOCK_ELEMENT_ID', $ids)
	->exec();

while ($item = $dbRes->fetch()) {
	$arPropTable[$item['IBLOCK_PROPERTY_ID']]['VALUES'][$item['IBLOCK_ELEMENT_ID']] = $item['VALUE'];
}

// все ненужное убираем из таблицы
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$isOnlyDiff = $request->get('different') === 'Y';
foreach ($arPropTable as $id => $prop) {
	// все незаполненные свойсвта убираем из таблицы
	if (!is_array($prop['VALUES']) || count($prop['VALUES']) === 0) {
		unset($arPropTable[$id]);
		continue;
	}
	// если показывать только различия - убираем одинаковые строчки
	if ($isOnlyDiff && count($prop['VALUES']) === count($arResult['ITEMS']) && count(array_unique($prop['VALUES'])) === 1) {
		unset($arPropTable[$id]);
	}
}

// итоговая таблица сравнения
$arResult['PROPERTIES'] = $arPropTable;
