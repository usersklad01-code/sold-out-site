<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***********************************************************************
 * Предобработка данных для страницы сравнения
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * ************************************************************************/
$this->setFrameMode(true);

// если список пуст - ничего не выводим
if (count($arResult['ITEMS']) === 0) {
	return;
}

// отображаем список сравнения ?>
<div class="compare__container compare-container-js">
    <div class="content">
        <?php

        // Карточки товары (обычные) ?>
        <div class="compare__cards compare-cards-js">
            <? foreach ($arResult["ITEMS"] as $itm) {
                $APPLICATION->IncludeComponent(
                    'bitrix:catalog.item',
                    'sku_card',
                    array(
                        "RESULT" => array(
                            "ITEM" => $itm,
                            "PRODUCT" => $arResult["PRODUCTS"][$itm["PRODUCT_ID"]],
                            "SECTION" => $arResult["SECTIONS"][$arResult["PRODUCTS"][$itm["PRODUCT_ID"]]["IBLOCK_SECTION_ID"]],
                            "AREA_ID" => $this->GetEditAreaId($itm["ID"]),
                        ),
                        "PARAMS" => array('IS_COMPARE' => "Y")
                    ),
                    $this->getComponent(),
                    array("HIDE_ICONS" => "Y")
                );
            } ?>
        </div>
        <?php

        // Таблица сравнения ?>
        <div class="compare__content">
            <div class="checkbox-filter">
                <label class="checkbox-filter__label">
                    <input class="checkbox-filter__input js-checkbox-filter" type="checkbox" name="difference" value="">
                    <span class="checkbox-filter__box"></span>
                    <span class="checkbox-filter__text">Показать только отличия</span>
                </label>
            </div>
            <div class="compare__content-title">Характеристики</div>
            <div class="compare__list-info js-compare-table" data-entity="properties">
                <? foreach ($arResult['PROPERTIES'] as $prop) {
                    if($prop['NAME']!=0){?>
                    <div class="compare__info-row">
                        <span class="compare__head-cell"><?= $prop['NAME'] ?></span>
                        <div class="compare__info-dd">
                            <? foreach ($arResult['ITEMS'] as $item) { ?>
                                <span class="compare__cell"><?= !empty($prop['VALUES'][$item['ID']]) ? $prop['VALUES'][$item['ID']] : '-' ?></span>
                            <? } ?>
                        </div>
                    </div>
                <? }
                } ?>
            </div>
        </div>
    </div>
</div>
