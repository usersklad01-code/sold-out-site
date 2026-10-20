<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***********************************************************************************
 * Слайдер с подборкой товаров
 * @var $arParams
 * @var $arResult
 * @global $APPLICATION
 * ************************************************************************************/
$this->setFrameMode(true);

// При недостаточном количествое товаров блок пропускается
if (!is_array($arResult["ITEMS"]) || count($arResult["ITEMS"]) < 4) {
	return;
}

// Ориентация блоков чередуется на странице, один справа на лево, друго - слева на право
$GLOBALS['numCompilationSlider']++;
if ($GLOBALS['numCompilationSlider'] % 2 === 0) {
	$extStyle = 'to-left';
}

// Слайдер ?>
<div class="catalog-wrap-block">
	<div>
		<div class="category-slider js-category-slider js-main-page-category-slider <?= $extStyle ?>">
			<div class="category-slider__card category-slider-card">
				<?php

				// Заголовок блока ?>
				<div class="category-slider-card__container">
					<div class="category-slider-card__title"><?= $arParams['TITLE'] ?></div>
				</div>
				<?php

				// Стрелки навигации для слайдера ?>
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
			<?php

			// Список товаров ?>
			<div class="category-slider__wrapper">
				<div class="swiper category-slider__slider js-slider">
					<div class="swiper-wrapper category-slider__slider-wrapper">
						<? foreach ($arResult["ITEMS"] as $i => $itm) { ?>
							<div class="swiper-slide category-slider__slide js-slide">
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
				</div>
			</div>
		</div>
	</div>
</div>