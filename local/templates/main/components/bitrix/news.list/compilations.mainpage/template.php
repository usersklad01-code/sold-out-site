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

$this->setFrameMode(true);

$currentPage = $APPLICATION->GetCurPage(); ?>

<?if (!empty($arResult['ITEMS'])){?>
    <div class="sec-main-catalog">
    <? foreach ($arResult['ITEMS'] as $key => $section) { ?>
        <? if (!empty($section["PROPERTIES"]['ELEMENTS']['VALUE'])) { ?>
            <div class="category-slider js-category-slider <?= ($key + 1) % 2 == 0 ? 'to-left' : '' ?> js-main-page-category-slider">
                <div class="category-slider__card category-slider-card">
                    <div class="category-slider-card__container">
                        <div class="category-slider-card__title"><?= $section['NAME'] ?></div>
                    </div>
                    <div class="category-slider-card__nav">
                        <button class="category-slider-card__nav-prev js-slider-btn-prev" type="button">
                            <svg width="13" height="10">
                                <use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-small-bold"></use>
                            </svg>
                        </button>
                        <button class="category-slider-card__nav-next js-slider-btn-next" type="button">
                            <svg width="13" height="10">
                                <use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-small-bold"></use>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="category-slider__wrapper">
                    <div class="swiper category-slider__slider js-slider">
                        <div class="swiper-wrapper category-slider__slider-wrapper">
                            <?foreach ($section['ELEMENTS'] as $itm) { ?>
                                <div class="swiper-slide category-slider__slide js-slide">
                                    <? $APPLICATION->IncludeComponent(
                                        'bitrix:catalog.item',
                                        'sku_card',
                                        array(
                                            "RESULT" => array(
                                                "ITEM" => $itm
                                            ),
                                            "PARAMS" => []
                                        ),
                                        $this->getComponent(),
                                        array("HIDE_ICONS" => "Y")
                                    ); ?>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
        <? } ?>
    <? } ?>
</div>
<?}?>