<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** ***********************************************************************
 * Шаблон вывода плитки товара (sku)
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * ************************************************************************/
$this->setFrameMode(true);

// объекты
$offer = $arResult["ITEM"];
$product = $arResult["PRODUCT"];
$section = $arResult["SECTION"];
if (!$offer) {
	return;
}

// сама карточка ?>
<div class="product-card js-sku-card <?= $arParams['IS_COMPARE'] === 'Y' ? 'product-card--compare' : '' ?>" id="<?= $arResult['AREA_ID'] ?>">
	<a class="overlink" href="<?= $offer['DETAIL_PAGE_URL'] ?>"></a>
	<? if ($arParams['IS_COMPARE'] === 'Y') { ?>
		<button class="product-card__del-card js-btn-compare" type="button" aria-label="Удалить из сравнения" data-id="<?= $offer['ID'] ?>">
			<svg width="24" height="24">
				<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#trash-red"></use>
			</svg>
		</button>
	<? } ?>
	<img class="product-card__img" src="<?= $offer['PREVIEW_PICTURE']['src'] ?>" alt="<?= $offer['NAME'] ?>">
	<div class="product-card__container">
		<div class="product-card__title"><?= $offer['NAME'] ?></div>
		<? if (!empty($offer["PRICE"]["RESULT_PRICE"])) { ?>
			<div class="product-card-price">
				<div class="product-card-price__main-value">
					<span><?= $offer["PRICE"]["RESULT_PRICE"]["DISCOUNT_PRICE_PRINT"] ?></span>
					<span class="rouble">₽</span>
				</div>
				<? if (!empty($offer["PRICE"]["RESULT_PRICE"]["DISCOUNT"])) { ?>
					<div class="product-card-price__sale">
						<div class="product-card-price__sale-value">
							<?= number_format($offer["PRICE"]["RESULT_PRICE"]["BASE_PRICE"], 0, '.', ' '); ?>₽
						</div>
						<? if (!empty($offer["PRICE"]["RESULT_PRICE"]["PERCENT"])) { ?>
							<div class="product-card-price__sale-percent">-<?= $offer["PRICE"]["RESULT_PRICE"]["PERCENT"] ?>%</div>
						<? } ?>
					</div>
				<? } ?>
			</div>
		<? } ?>
	</div>
</div>