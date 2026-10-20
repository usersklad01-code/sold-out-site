<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** *************************************************************************
 * Слайдер аксессуаров
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * **************************************************************************/
$this->setFrameMode(true); ?>
<div class="sec-main-catalog">
    <div class="category-slider js-category-slider js-main-page-category-slider">
        <div class="category-slider__card category-slider-card">
            <div class="category-slider-card__container">
                <div class="category-slider-card__title">Аксессуары</div>
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
							$item = current($item['OFFERS']);
						}
						// плитка товара ?>
                        <div class="swiper-slide category-slider__slide js-slide">
                            <? $APPLICATION->IncludeComponent(
                                'bitrix:catalog.item',
                                'sku_card.simple',
								array(
									'RESULT' => array(
										'ITEM' => $item,
										'LINK_ITEM' => $arParams['LINK_ITEM'],
										'AREA_ID' => $this->GetEditAreaId($item['ID']),
									),
									'PARAMS' => []
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