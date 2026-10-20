<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Выбор местоположения
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * ***************************************************************************/


// Плашка текущего местоположения ?>
<div class="header__loc" data-entity="location">
	<a class="header__loc-link js-show-popup" role="button" href="javascript:void(0)" data-popup="popup-location" data-open-modal="select-city">
		<span><?= $arResult['LOCATION']['NAME'] ?: 'Город' ?></span>
		<svg width="10" height="8">
			<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#arrow-menu"></use>
		</svg>
	</a>
</div>
<?php


//// Местоположение в подвале
//$this->SetViewTarget('footerLocation'); ?>
<!--	<div class="header__loc" data-entity="location">-->
<!--		<a class="header__loc-link js-show-popup" role="button" href="javascript:void(0)" data-popup="popup-location" data-open-modal="select-city">-->
<!--			<span>--><?php //= $arResult['LOCATION']['NAME'] ?: 'Город' ?><!--</span>-->
<!--			<svg width="10" height="8">-->
<!--				<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#arrow-menu"></use>-->
<!--			</svg>-->
<!--		</a>-->
<!--		--><?// if ($arResult['LOCATION']['NAME'] == 'Санкт-Петербург') { ?>
<!--			<span>--><?// include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/include_areas/footer/address.html"); ?><!--</span>-->
<!--		--><?// } ?>
<!--	</div>-->
<?// $this->EndViewTarget();