<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true); ?>

<? if (count($arResult['ITEMS']) > 0) { ?>
    <div class="features">
        <? foreach ($arResult['ITEMS'] as $arItem) { ?>
            <div class="feature-item">
                <a class="overlink" href="<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?: 'javascript:void(0)' ?>"></a>
                <? if (!empty($arItem['PROPERTIES']['ICON']['VALUE'])) { ?>
                    <img style="margin: auto"
                         src="<?= $arItem['DISPLAY_PROPERTIES']['ICON']['FILE_VALUE']['SRC'] ?>"
                         alt="<?= $arItem['NAME'] ?>"
                    >
                <? } ?>
                <div class="feature-item__container">
                    <span><?= $arItem['NAME'] ?></span>
                    <svg width="14" height="8">
                        <use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-small"></use>
                    </svg>
                </div>
            </div>
        <? } ?>
    </div>
<? } ?>