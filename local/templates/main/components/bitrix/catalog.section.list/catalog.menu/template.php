<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Список разделов на главной
 * @var array $arParam
 * @var array $arResult
 * ***************************************************************************/
$this->setFrameMode(true);

// Десктопное меню ?>
<nav class="header-bottom-menu__nav">
	<ul class="header-bottom-menu__nav-list">
		<? foreach ($arResult['SECTIONS'] as $item) { ?>
            <?if($item['RELATIVE_DEPTH_LEVEL']==1){?>
                <li class="header-bottom-menu__nav-item">
                    <a class="menu-link" href="<?= $item['SECTION_PAGE_URL'] ?>">
                        <?= $item["NAME"] ?>
                    </a>
                </li>
            <? } ?>
		<? } ?>
	</ul>
</nav>
<?php

// Мобильное меню
$this->SetViewTarget('mobileCatalogMenu'); ?>
    <ul class="mob-menu__categories list-style-none">
        <? foreach ($arResult['SECTIONS'] as $item) { ?>
            <? if ($item['RELATIVE_DEPTH_LEVEL'] == 1) { ?>
                <li class="mob-menu__categories-item ">
                    <div class=" mob-menu__opensub" style="cursor:pointer;">
                        <a href="<?= $item['SECTION_PAGE_URL'] ?>" class="menu-mobile-link">
                            <?= $item['NAME'] ?>
                        </a>
                        <div class="mob-menu-arrow">
                            <svg width="16" height="8">
                                <use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#bold-arrow-down"></use>
                            </svg>
                        </div>
                    </div>

                    <ul class="mob-menu__subcategories list-style-none">
                        <?php foreach ($arResult['SECTIONS'] as $subItem) { ?>
                            <?php if ($subItem['RELATIVE_DEPTH_LEVEL'] == 2 && $subItem['IBLOCK_SECTION_ID'] == $item['ID']) { ?>
                                <li class="mob-menu__subcategories-item">
                                    <a href="<?= $subItem['SECTION_PAGE_URL'] ?>" class="menu-link">
                                        <?= $subItem["NAME"] ?>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
            <? } ?>
        <? } ?>
    </ul>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggles = document.querySelectorAll('.mob-menu__opensub');
            toggles.forEach(function(toggle) {
                var subcategories = toggle.closest('.mob-menu__categories-item').querySelector('.mob-menu__subcategories');
                var arrow = toggle.querySelector('.mob-menu-arrow');
                if (subcategories && subcategories.children.length > 0) {
                    toggle.addEventListener('click', function(event) {
                        event.preventDefault();
                        subcategories.classList.toggle('show');
                    });
                } else {
                    arrow.style.display = 'none';
                }
            });
        });
    </script>

<? $this->EndViewTarget();

// Меню в подвале (выводим в 3 столбика)
$this->SetViewTarget('footerCatalogMenu'); ?>
<?$mas=[];//собираем массив 1 уровня иначе в столбцах будет разное число элементов
 foreach ($arResult['SECTIONS'] as $key=> $item) {
    if($item['RELATIVE_DEPTH_LEVEL']==1){
        $mas[] = $item;
        }
    }?>
<?
$columnCount = 1;
$itemCount = count($mas);
for ($column = 0; $column < $columnCount; $column++) {?>
    <ul class="footer-navigation-links__list list-style-none js-nav-list">
        <? for ($i = $column; $i < $itemCount; $i += $columnCount) {?>
            <li>
                <a class="footer-link menu-link" href="<?= $mas[$i]['SECTION_PAGE_URL'] ?>">
                    <?= $mas[$i]['NAME'] ?>
                </a>
            </li>
        <? } ?>
    </ul>
<? } ?>
<? $this->EndViewTarget();