<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Нижнее меню
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * ***************************************************************************/
$this->setFrameMode(true); ?>
<nav class="footer-other-links">
	<ul class="footer-other-links__list list-style-none">
		<? foreach ($arResult as $item) { ?>
			<li class="<?= !empty($item["SELECTED"]) ? 'is-active' : '' ?>">
				<a class="footer-link menu-link" href="<?= $item["LINK"] ?>">
					<?= $item["TEXT"] ?>
				</a>
			</li>
		<? } ?>
	</ul>
</nav>
