<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** *************************************************************************
 * Слайдер рекомендаций BigData
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * **************************************************************************/
$this->setFrameMode(true);

// Если элементов нет - ничего не выводим
if (!is_array($arResult['ITEMS']) || count($arResult['ITEMS']) < 4) {
	return;
}

// Слайдер ?>
<div class="sec-main-catalog">
    <div class="category-slider js-category-slider js-main-page-category-slider">
        <div class="category-slider__card category-slider-card">
            <div class="category-slider-card__container">
                <div class="category-slider-card__title">Вам может понравиться</div>
            </div>
            <div class="category-slider-card__nav">
                <button class="category-slider-card__nav-prev js-slider-btn-prev" type="button">
                    <svg width="13" height="10">
                        <use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-small-bold"></use>
                    </svg>
                </button>
                <button class="category-slider-card__nav-next js-slider-btn-next" type="button">
                    <svg width="13" height="10">
                        <use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-small-bold"></use>
                    </svg>
                </button>
            </div>
        </div>

        <div class="category-slider__wrapper">
            <div class="swiper category-slider__slider js-slider">
                <div class="swiper-wrapper category-slider__slider-wrapper">
                    <?foreach ($arResult['ITEMS'] as $item) {
						// если это товар с sku - выводим первый sku
						if (is_array($item['OFFERS']) && count($item['OFFERS']) > 0) {
							$sku = current($item['OFFERS']);
							$sku['PRODUCT_ID'] = \CCatalogSku::GetProductInfo($sku['ID']);
							$sku['PRICE'] = \CCatalogProduct::GetOptimalPrice($sku['ID']);
						} else {
							$sku = $item;
						}
						// плитка товара ?>
                        <div class="swiper-slide category-slider__slide js-slide">
                            <? $APPLICATION->IncludeComponent(
								'bitrix:catalog.item',
								'sku_card',
								array(
									"RESULT" => array(
										"ITEM" => $sku,
										"PRODUCT" => $item,
										"SECTION" => $arResult["SECTIONS"]["PATH"][0],
										"AREA_ID" => $this->GetEditAreaId($sku["ID"]),
									),
									"PARAMS" => []
								),
								$this->getComponent(),
								array("HIDE_ICONS" => "Y")
							); ?>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</div>