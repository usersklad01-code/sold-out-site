<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** *************************************************************************
 * Слайдер на главной
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * **************************************************************************/
$this->setFrameMode(true);

// если элементов нет - пропускаем баннер
if (count($arResult['ITEMS']) === 0) {
	return;
}

// слайдер ?>
<div class="<?= $arParams["WRAPPER"] ?: 'sec-products-catalog__slider' ?>">
	<div class="promo-slider">
		<div class="swiper promo-slider__slider js-promo-slider">
			<div class="swiper-wrapper">
				<? foreach ($arResult['ITEMS'] as $arItem) { ?>
					<div class="swiper-slide promo-slider__slide">
						<div class="promo-slider__slide-content">
							<div class="promo-slider__slide-title">
								<?= $arItem['NAME'] ?>
							</div>
							<? if (!empty($arItem['PREVIEW_TEXT'])) { ?>
								<div class="promo-slider__slide-text">
									<?= $arItem['~PREVIEW_TEXT'] ?>
								</div>
							<? } ?>
							<? if (!empty($arItem['PROPERTIES']['LINK']['VALUE'])) { ?>
								<a class="btn promo-slider__slide-btn" style="height:38px;width:fit-content;min-width:fit-content;" href="<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>">
									<span class="btn__label">Посмотреть</span>
								</a>
							<? } ?>
						</div>
						<img class="<?= $arItem['PROPERTIES']['PICTURE_VIEW']['VALUE_XML_ID'] == 'img' ? 'promo-slider__slide-img' : 'promo-slider__slide-bg' ?>" src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>">
						<div class="promo-slider__nav">
							<div class="slider-button-prev promo-slider__nav-prev">
								<svg width="20" height="12" stroke="black">
									<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-big"></use>
								</svg>
							</div>
							<div class="slider-button-next promo-slider__nav-next">
								<svg width="20" height="12" stroke="black">
									<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-big"></use>
								</svg>
							</div>
						</div>
					</div>
				<? } ?>
			</div>
			<div class="swiper-pagination promo-slider__pagination"></div>
		</div>
	</div>
</div>