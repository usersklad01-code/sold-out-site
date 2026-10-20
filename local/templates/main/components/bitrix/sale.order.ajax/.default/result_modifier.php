<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */
use \Bitrix\Catalog\StoreTable;


$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);

/*foreach ($arResult['JS_DATA']['DELIVERY'] as &$delivery) {
    if (!empty($delivery['STORE'])){
        $delivery['STORE'] = StoreTable::getList([
            'select' => ['*'],
            'filter' => [
                'ID' => $delivery['STORE']
            ]
        ])->fetchAll();
    }
}*/


