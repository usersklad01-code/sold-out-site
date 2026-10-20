<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Список разделов на главной
 * @var array $arParam
 * @var array $arResult
 * ***************************************************************************/
$this->setFrameMode(true);


foreach ($arResult["SECTIONS"] as $arSection) { ?>
	<a href="<?= $arSection["SECTION_PAGE_URL"] ?>" class="categories__list__item">
		<?= $arSection["NAME"] ?>
	</a>
<? } ?>


