<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Меню ЛК
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * ***************************************************************************/
$this->setFrameMode(true); ?>

<? if (!empty($arResult)) { ?>
	<ul class="pc__main-links">
		<? foreach ($arResult as $arItem) { ?>
			<li>
				<a class="pc__main-link <?= !empty($arItem["SELECTED"]) ? 'is-active' : '' ?>" href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
			</li>
		<? } ?>
	</ul>
<? } ?>