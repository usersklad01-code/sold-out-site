<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** *************************************************************************
 * Иконка избранного
 * @var array $arParams
 * **************************************************************************/
$oFav = \Cake\Services\Favorites::getInstance(); ?>
<a class="btn--gray <?= $arParams['CSS'] ?> <?= $oFav->count() > 0 ? 'is-active' : '' ?>" href="/personal/favorites/" title="Избранное">
	<svg width="20px" height="20px" viewBox="0 0 16 14">
		<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#hart"></use>
	</svg>
	<span class="header-icon-btn__content js-favorites-counter" <?= $oFav->count() > 0 ? '' : 'style="display:none"' ?>><?= $oFav->count() ?></span>
</a>