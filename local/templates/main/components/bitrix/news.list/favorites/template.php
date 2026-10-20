<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Шаблон для избранного
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * ***************************************************************************/
$this->setFrameMode(true);
\Bitrix\Main\Loader::includeModule('salse');

// Проверка на пустоту
if (count($arResult['ITEMS']) === 0) { ?>
	<div class="pc__main-content">
		Список избранного пуст. Перейти в <a href="/catalog/"><b>каталог</b></a>
	</div>
	<? return;
}

// Шаблон вывода списка ?>
<div class="sec-products-catalog__list js-catalog-list grid-view">
	<? foreach ($arResult["ITEMS"] as $itm) { ?>
		<div>
			<? $itm['PRODUCT_ID'] = CCatalogSku::GetProductInfo($itm['ID']); ?>
			<? $itm['PRICE'] = \CCatalogProduct::GetOptimalPrice($itm['ID']); ?>
			<? $APPLICATION->IncludeComponent(
				'bitrix:catalog.item',
				'sku_card',
				array(
					"RESULT" => array(
						"ITEM" => $itm,
						"PRODUCT" => $arResult["PRODUCTS"][$itm["PRODUCT_ID"]],
						"SECTION" => $arResult["SECTIONS"][$arResult["PRODUCTS"][$itm["PRODUCT_ID"]]["IBLOCK_SECTION_ID"]],
						"AREA_ID" => $this->GetEditAreaId($itm["ID"]),
					),
					"PARAMS" => []
				),
				$this->getComponent(),
				array("HIDE_ICONS" => "Y")
			); ?>
		</div>
	<? } ?>
</div>