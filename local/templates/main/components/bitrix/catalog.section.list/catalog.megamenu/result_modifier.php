<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 */

$tree = [];
$validParents = [];
$filteredSections = [];

// Собираем все разделы в дерево
foreach ($arResult['SECTIONS'] as $section) {
    $parentId = (int)$section['IBLOCK_SECTION_ID'];
    $tree[$parentId][] = $section;
}

// Проверяем, есть ли у родительских разделов непустые подразделы
foreach ($tree[0] as $parentSection) {
    $parentId = $parentSection['ID'];

    // Проверяем, есть ли у этого родителя подразделы
    if (!empty($tree[$parentId])) {
        $hasNonEmptyChildren = false;

        // Проверяем каждый подраздел
        foreach ($tree[$parentId] as $childSection) {
            // Проверяем, есть ли у подраздела элементы или свои подразделы
            if ($childSection['ELEMENT_CNT'] > 0 || !empty($tree[$childSection['ID']])) {
                $hasNonEmptyChildren = true;
                break;
            }
        }

        // Если есть непустые подразделы, добавляем родителя в список валидных
        if ($hasNonEmptyChildren) {
            $validParents[] = $parentId;
            $filteredSections[] = $parentSection;
        }
    }
}

// Фильтруем все разделы, оставляем только:
// 1. Родительские разделы из $validParents
// 2. Подразделы, у которых есть элементы или свои подразделы
$arResult['SECTIONS'] = array_filter($arResult['SECTIONS'], function($section) use ($validParents, $tree) {
    $sectionId = (int)$section['ID'];
    $parentId = (int)$section['IBLOCK_SECTION_ID'];

    // Если это родительский раздел (parentId = 0)
    if ($parentId === 0) {
        return in_array($sectionId, $validParents);
    }

    // Если это подраздел, проверяем наличие элементов или своих подразделов
    return ($section['ELEMENT_CNT'] > 0 || !empty($tree[$sectionId]));
});

// Переиндексируем массив (на всякий случай)
$arResult['SECTIONS'] = array_values($arResult['SECTIONS']);

// Добавляем в arResult информацию об отфильтрованных родительских разделах
// Это может пригодиться в шаблоне
$arResult['FILTERED_PARENTS'] = $filteredSections;
$arResult['VALID_PARENTS_IDS'] = $validParents;