<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Верхнее меню
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * ***************************************************************************/
$this->setFrameMode(true);

// Нужно ли вообще что-то выводить
if (empty($arResult)) {
	return;
}

// Десктопное меню ?>
<nav class="header-top-menu__nav">
	<ul class="header-top-menu__nav-list">
		<? foreach ($arResult as $item) { ?>
			<li class="header-top-menu__nav-item <?= !empty($item["SELECTED"]) ? 'is-active' : '' ?>">
				<a class="menu-link" href="<?= $item["LINK"] ?>">
					<?= $item["TEXT"] ?>
				</a>
			</li>
		<? } ?>
	</ul>
</nav>
<?php

// Мобильное меню
$this->SetViewTarget('mobileTopMenu'); ?>
	<nav class="mob-menu__nav">
		<ul class="list-style-none">
			<? foreach ($arResult as $item) { ?>
				<li class="<?= !empty($item["SELECTED"]) ? ' is-active' : '' ?>">
					<a class="header-link" href="<?= $item["LINK"] ?>">
						<?= $item["TEXT"] ?>
					</a>
				</li>
			<? } ?>
		</ul>
	</nav>
<? $this->EndViewTarget();