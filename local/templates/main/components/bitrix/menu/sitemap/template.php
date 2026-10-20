<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Нижнее меню
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * ***************************************************************************/
$this->setFrameMode(true); ?>
<?if($arParams['ROOT_MENU_TYPE'] == 'personal'){?>
    <div class="categories__list">
        <? foreach ($arResult as $item) { ?>
            <a class="categories__list__item" href="<?= $item["LINK"] ?>"><?= $item["TEXT"] ?></a>
        <?}?>
    </div>
<?}
else{?>
    <? foreach ($arResult as $item) { ?>
        <div class="categories__item">
            <a class="categories__title" href="<?= $item["LINK"] ?>"><?= $item["TEXT"] ?></a>
        </div>
    <?}
}?>

