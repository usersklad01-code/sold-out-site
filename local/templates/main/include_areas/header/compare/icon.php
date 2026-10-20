
<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** *************************************************************************
 * Иконка сравнения
 * @var array $arParams
 * **************************************************************************/
$oCompare = \Cake\Services\Compare::getInstance(); ?>
<a class="<?= $arParams['CSS'] ?> <?= $oCompare->count() > 0 ? 'is-active' : '' ?>" href="/personal/compare/" title="Сравнение">
	<svg width="20" height="20" stroke="#000000">
		<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#compare"></use>
	</svg>
	<span class="header-icon-btn__content js-compare-counter" <?= $oCompare->count() > 0 ? '' : 'style="display:none"' ?>><?= $oCompare->count() ?></span>
</a>