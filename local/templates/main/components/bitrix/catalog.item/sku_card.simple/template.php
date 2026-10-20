<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** ***********************************************************************
 * Шаблон вывода упрощенной плитки товара (sku)
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * ************************************************************************/
$this->setFrameMode(true);
$item = $arResult['ITEM']; ?>

<div class="product-card js-sku-card">

	<?php
	// картинка ?>

	<img class="product-card__img" src="<?= $item['PREVIEW_PICTURE']['src'] ?>" alt="<?= $item['NAME'] ?>">
	<?php

	// контентная часть ?>
	<div class="product-card__container">
		<?php

		// название ?>
		<div class="product-card__title"><?= $item['NAME'] ?></div>
		<?php

		// цена
		if (!empty($item["PRICE"]["RESULT_PRICE"])) { ?>
			<div class="product-card-price">
				<div class="product-card-price__main-value">
					<span><?= $item["PRICE"]["RESULT_PRICE"]["DISCOUNT_PRICE_PRINT"] ?></span>
					<span class="rouble">₽</span>
				</div>

				<? if (!empty($item["PRICE"]["RESULT_PRICE"]["DISCOUNT"])) { ?>
					<div class="product-card-price__sale">
						<div class="product-card-price__sale-value">
							<?= number_format($item["PRICE"]["RESULT_PRICE"]["BASE_PRICE"], 0, '.', ' '); ?> ₽
						</div>
						<? if (!empty($item["PRICE"]["RESULT_PRICE"]["PERCENT"])) { ?>
							<div class="product-card-price__sale-percent">
								-<?= $item["PRICE"]["RESULT_PRICE"]["PERCENT"] ?>%
							</div>
						<? } ?>
					</div>
				<? } ?>
			</div>
		<? }

		// преимущества ?>
		<div class="product-card-details">
			<? $arDelivery = \Cake\Company\Contacts::getDeliveryList();
			foreach ($arDelivery as $deliveryCode => $deliveryItem) { ?>
				<div class="product-card-details__item">
					<svg width="17" height="11">
						<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#<?= $deliveryCode ?>"></use>
					</svg>
					<span class="product-card-details__item-text product-card-details__item-text--short"><?= $deliveryItem['NAME'] ?> <?= $deliveryItem['DESCRIBE'] ?></span>
					<span class="product-card-details__item-text product-card-details__item-text--full"><?= $deliveryItem['NAME'] ?> <?= $deliveryItem['DESCRIBE_FULL'] ?></span>
				</div>
			<? } ?>
		</div>
		<?php

		// кнопки покупки ?>
		<!--<div class="product-card__btns">
			<button class="btn btn--small product-card__bought js-btn-buy" type="button" data-id="<?= $item['ID'] ?>" data-basket-prop="prop[link][name]=Аксессуар для товара&prop[link][value]=<?= $arResult["LINK_ITEM"]["NAME"] ?>(<?= $arResult["LINK_ITEM"]["ID"] ?>)">
				<span class="btn__label">Купить</span>
				<svg class="btn__icon btn__icon--right" width="16" height="11">
					<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#cart"></use>
				</svg>
				<span class="btn__loader-icon">
					<div class="loading-icon js-button-loader"><div></div><div> </div><div></div></div>
				</span>
			</button>
		</div>
        <button class="btn btn--small product-card__bought-one-click js-btn-oneclick" type="button" data-id="<?= $item['ID'] ?>">
            <span class="btn__label">Купить в 1 клик</span>
            <span class="btn__loader-icon">
				<div class="loading-icon js-button-loader"><div></div><div> </div><div></div></div>
            </span>
        </button>-->

        <div class="btn btn--small product-card__bought js-btn-buy<?= $item['PRODUCT']['AVAILABLE'] === 'N' ? ' btn--gray' : '' ?>" data-id="<?= $item['ID'] ?>" data-basket-prop="prop[link][name]=Аксессуар для товара&prop[link][value]=<?= $arResult["LINK_ITEM"]["NAME"] ?>(<?= $arResult["LINK_ITEM"]["ID"] ?>)" <?= $item['PRODUCT']['AVAILABLE'] === 'N' ? 'disabled' : '' ?> onclick="ym(53942923,'reachGoal','dobavlenie_v_korziny')">
            <span class="btn__label">Купить</span>
            <svg class="btn__icon btn__icon--right" width="16" height="11">
                <use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#cart"></use>
            </svg>
            <div class="btn__loader-icon">
                <div class="loading-icon js-button-loader"><div></div><div> </div><div></div></div>
            </div>
        </div>
	</div>
</div>