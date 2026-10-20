<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** ***********************************************************************
 * Шаблон для тегов в каталоге
 *
 * @var array $arResult
 * @var array $arParams
 * ************************************************************************/

$this->setFrameMode(true);

// Шаблон отображения ?>
<div class="category-tags">
    <? foreach($arResult['ITEMS'] as $tag) {
        if ($tag->isActive() && $tag->getCountChildElements() > 0) {
            $url = $tag->getUrl();
            $isActive = strstr($arParams['CUR_DIR'], $url); ?>
                <a class="category-tags__link <?= ($isActive ? 'is-active' : '') ?>" role="button" href="<?= $url ?>">
                    <?= $tag->getName() ?>
                </a>
        <? }
    } ?>
</div>
