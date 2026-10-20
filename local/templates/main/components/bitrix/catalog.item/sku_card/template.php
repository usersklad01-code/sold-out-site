<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
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
<div style="min-width: 100px;" class="product-card js-sku-card <?= $arParams['IS_COMPARE'] === 'Y' ? 'product-card--compare' : '' ?>" id="<?= $arResult['AREA_ID'] ?>">
	<a class="overlink" href="<?= $offer['DETAIL_PAGE_URL'] ?>"></a>
	<? if ($arParams['IS_COMPARE'] === 'Y') { ?>
		<button class="product-card__del-card js-btn-compare" type="button" aria-label="Удалить из сравнения" data-id="<?= $offer['ID'] ?>">
			<svg width="24" height="24"><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#trash-red"></use></svg>
		</button>
	<? } ?>


    <img class="product-card__img" src="<?=$offer['PREVIEW_PICTURE']['src']?>" alt="<?=$offer['NAME']?>">
	<div class="product-card__container">
		<div class="product-card__title"><?=$offer['NAME']?></div>

		<?if(!empty($offer["PRICE"]["RESULT_PRICE"])):?>
			<div class="product-card-price">
				<div class="product-card-price__main-value">
					<span><?=$offer["PRICE"]["RESULT_PRICE"]["DISCOUNT_PRICE_PRINT"]?></span>
					<span class="rouble">₽</span>
				</div>

				<?if(!empty($offer["PRICE"]["RESULT_PRICE"]["DISCOUNT"])):?>
					<div class="product-card-price__sale">
						<div class="product-card-price__sale-value"><?=number_format($offer["PRICE"]["RESULT_PRICE"]["BASE_PRICE"], 0, '.', ' ');?> ₽</div>
						<?if(!empty($offer["PRICE"]["RESULT_PRICE"]["PERCENT"])):?>
							<div class="product-card-price__sale-percent">-<?=$offer["PRICE"]["RESULT_PRICE"]["PERCENT"]?>%</div>
						<?endif?>
					</div>
				<?endif?>
                <div class="product-card__availabl <?= ($offer['CATALOG_AVAILABLE'] !== 'N' ? 'available' : 'not-available') ?>">
                    <span><?= ($offer['CATALOG_AVAILABLE'] !== 'N' ? 'В наличии' : 'Временно отсутствует') ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9058 5.09916C12.1311 5.32329 12.132 5.68756 11.9078 5.91279L7.54673 10.2953C7.29648 10.5468 6.88932 10.5464 6.63957 10.2944L7.0482 9.8894L6.63957 10.2944L4.64919 8.28626C4.42551 8.06058 4.42713 7.69631 4.6528 7.47263C4.87848 7.24895 5.24276 7.25057 5.46644 7.47624L7.09432 9.11866L11.0922 5.10115C11.3163 4.87592 11.6806 4.87503 11.9058 5.09916Z" fill="#E84E0F"/>
                        <circle cx="8.27893" cy="7.72107" r="7.22107" stroke="#E84E0F"/>
                    </svg>
                </div>
			</div>
		<?endif?>
		<?php

		// Иконки рейтинга и отзывов
		if($product['PROPERTY_RATING_CNT_VALUE'] > 0) { ?>
			<div class="product-card-rating">
				<div class="product-card-rating__stars">
					<svg width="14" height="14"><use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#star"></use></svg>
					<span><?=$product['PROPERTY_RATING_AVG_VALUE']?></span>
				</div>
				<div class="product-card-rating__feedbacks">
					<svg width="14" height="14"><use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#feedback-cloud"></use></svg>
					<span><?=$product['PROPERTY_RATING_CNT_VALUE']?></span>
				</div>
			</div>
		<? } ?>

		<div class="product-card-details">
			<? $arDelivery = \Cake\Company\Contacts::getDeliveryList();
			foreach ($arDelivery as $deliveryCode => $deliveryItem) { ?>
				<div class="product-card-details__item">
					<svg width="17" height="11"><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#<?= $deliveryCode ?>"></use></svg>
					<span class="product-card-details__item-text product-card-details__item-text--short"><?= $deliveryItem['NAME'] ?> <?= $deliveryItem['DESCRIBE'] ?></span>
					<span class="product-card-details__item-text product-card-details__item-text--full"><?= $deliveryItem['NAME'] ?> <?= $deliveryItem['DESCRIBE_FULL'] ?></span>
				</div>
			<? } ?>
		</div>
		<div class="product-card__btns">
			<? if ($offer['CATALOG_AVAILABLE'] !== 'N') { ?>
				<div class="btn btn--small product-card__bought js-btn-buy" data-id="<?= $offer['ID'] ?>" onclick="ym(53942923,'reachGoal','dobavlenie_v_korziny')">
					<span class="btn__label">Купить</span>
					<svg class="btn__icon btn__icon--right" width="16" height="11">
						<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#cart"></use>
					</svg>
					<div class="btn__loader-icon">
						<div class="loading-icon js-button-loader"><div></div><div> </div><div></div></div>
					</div>
				</div>
				<button class="btn btn--small product-card__bought-one-click js-btn-oneclick" type="button" data-id="<?= $offer['ID'] ?>" onclick="ym(53942923,'reachGoal','1click')">
					<span class="btn__label">Купить в 1 клик</span>
				</button>
			<? } else { ?>
				<button class="btn btn--small product-card__bought btn--gray">Отсутствует</button>
			<? } ?>
		</div>

        <div class="product-card__btns-other">
            <div class="btn round-btn btn--gray btn-product js-btn-favorites" data-id="<?=$offer['ID']?>">
                <span class="btn__label"></span>
                <svg class="btn__icon btn__icon--right" width="16" height="11"><use xlink:href="<?=SITE_TEMPLATE_PATH?>/tpl/assets/icons/sprite.svg#hart"></use></svg>
                <div class="btn__loader-icon"><div class="loading-icon js-button-loader"><div></div><div> </div><div></div></div></div>
            </div>
            <div class="btn round-btn round-btn-xl btn-product btn--gray js-btn-compare" data-id="<?=$offer['ID']?>">
                <span class="btn__label"></span>
                <svg class="btn__icon btn__icon--right" width="16" height="11"><use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#compare"></use></svg>
                <div class="btn__loader-icon"><div class="loading-icon js-button-loader"><div></div><div> </div><div></div></div></div>
            </div>
        </div>
	</div>
</div>