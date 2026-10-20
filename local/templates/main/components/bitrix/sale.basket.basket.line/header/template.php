<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** ***********************************************************************
 * Корзина в шапке
 * @var array $arParams
 * @var array $arResult
 * ************************************************************************/

// Всплывающая корзина ?>
<div class="js-basket-content">
	<a class="header-top-menu__cart-btn header-icon-btn " href="<?= $arParams['PATH_TO_BASKET'] ?>" >
		<svg width="20" height="20" stroke="#000000">
			<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#cart"></use>
		</svg>
		<span class="header-icon-btn__content js-basket-items-count" <?= $arResult['NUM_PRODUCTS'] == 0 ? 'style="display:none"' : '' ?>>
            <?= $arResult['NUM_PRODUCTS'] ?>
        </span>
	</a>
</div>
<?php

// Подключение скриптов
$basketItems = [];
foreach ($arResult["CATEGORIES"] as $category => $items) {
	foreach ($items as $item) {
		$basketItems[] = array(
			'id' => $item['ID'],
			'name' => $item['NAME'],
			'url' => $item['DETAIL_PAGE_URL'],
			'price' => $item['PRICE_FMT'],
			'priceOld' => $item["FULL_PRICE"] != $item["PRICE_FMT"] ? $item['FULL_PRICE'] . '₽' : '',
		);
	}
} ?>
<script type="text/javascript">
	$(document).ready(function () {
		new BitrixSmallCart(<?= \Bitrix\Main\Web\Json::encode(array(
			'urlBasket' => $arParams['PATH_TO_BASKET'],
			'urlAdd' => $this->getFolder() . '/add.php',
			'urlRefresh' => $this->getFolder() .'/ajax.php',
			'basketItems' =>  $basketItems
		))?>);
	});
</script>
<?php

// Мобильная корзина
$this->SetViewTarget('mobileBasket'); ?>
	<a class="mob-panel__cart-btn header-icon-btn" href="<?= $arParams['PATH_TO_BASKET'] ?>">
		<svg width="20" height="20" stroke="#000000">
			<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#cart"></use>
		</svg>
		<span class="footer__mob-panel__btn-content js-basket-items-count" <?= $arResult['NUM_PRODUCTS'] == 0 ? 'style="display:none"' : '' ?>>
             <?= $arResult['NUM_PRODUCTS'] ?>
        </span>
	</a>
<? $this->EndViewTarget();