<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** *************************************************************************
 * Список разделов на главной
 * @var array $arParam
 * @var array $arResult
 * @global \CMain $APPLICATION
 * **************************************************************************/

$this->setFrameMode(true); ?>

<div class="sec-categories">
	<? $count = 0; ?>
	<? foreach ($arResult['SECTIONS'] as $key => $arSection) { ?>
		<div class="sec-categories__item sec-categories__item--<?= (++$count) ?>">
			<div class="category-card">
				<a class="overlink" href="<?= $arSection['SECTION_PAGE_URL'] ?>"></a>
				<div class="category-card__title">
					<span><?= $arSection['NAME'] ?></span>
				</div>
				<img class="category-card__img" src="<?= $arSection['PICTURE']['SRC'] ?>" alt="<?= $arSection['PICTURE']['ALT'] ?>">
			</div>
		</div>
	<? } ?>
</div>
