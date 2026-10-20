<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

$strTitle = "";

$tree = [];

// Собираем дерево из отфильтрованных разделов
foreach ($arResult['SECTIONS'] as $section) {
    $parentId = (int)$section['IBLOCK_SECTION_ID'];
    $tree[$parentId][] = $section;
}

?>

<div class="catalog-mega">

    <div class="catalog-mega__left">
        <?php if (!empty($tree[0])): ?>
            <?php $isFirst = true; ?>
            <?php foreach ($tree[0] as $section): ?>
                <a href="<?= $section['SECTION_PAGE_URL']?>" class="catalog-mega__left-item <?= $isFirst ? 'active' : '' ?>"
                     data-id="<?= $section['ID'] ?>">
                    <span><?= $section['NAME'] ?></span>
                    <span class="catalog-mega__arrow">
                    <svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.40873 5.49694C6.40873 5.24597 6.31692 5.03784 6.12104 4.84196L1.40784 0.23261C1.24869 0.0734558 1.05894 5.89155e-08 0.832462 4.63151e-08C0.373384 2.07737e-08 -2.00921e-08 0.361158 -4.56328e-08 0.820256C-5.82329e-08 1.04674 0.0979366 1.25487 0.263205 1.42014L4.45 5.49082L0.263204 9.57373C0.0979361 9.73901 -5.53042e-07 9.94101 -5.65983e-07 10.1736C-5.91524e-07 10.6327 0.373383 11 0.832461 11C1.05894 11 1.24869 10.9204 1.40784 10.7613L6.12104 6.15192C6.32304 5.95604 6.40873 5.74791 6.40873 5.49694Z" fill="#E84E0F"/>
                    </svg>
                </span>
                </a>
                <?php $isFirst = false; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>


    <div class="catalog-mega__right">
        <?php foreach ($tree as $parentId => $sections): ?>
            <?php if ($parentId == 0) continue; ?>

            <?php
            $firstParentId = !empty($tree[0][0]['ID']) ? $tree[0][0]['ID'] : 0;
            ?>
            <div class="catalog-mega__right-block <?= ($parentId == $firstParentId) ? 'active' : '' ?>"
                 data-parent="<?= $parentId ?>">
                <?php foreach ($sections as $section): ?>
                    <a href="<?= $section['SECTION_PAGE_URL'] ?>"
                       class="catalog-mega__link">
                        <?= $section['NAME'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

</div>


