<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Форма поиска
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * ***************************************************************************/
$this->setFrameMode(true);

// Иконка поиска (лупа) ?>
<button class="header-bottom-menu__search-btn js-toggle-header-search">
    <span>Поиск</span>
    <svg width="14" height="14" stroke="#000000">
        <use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#loupe"></use>
    </svg>
</button>
<?php

// Форма поиска ?>
<div class="header-bottom-menu__search js-header-search">
    <form class="header-bottom-menu__search-form" id="searchTopForm" action="<?= $arResult["FORM_ACTION"] ?>" method="get">
        <input class="header-bottom-menu__search-input" type="text" placeholder="Поиск" name="q" autocomplete="off" value="<?= $arResult["REQUEST"]["QUERY"] ?>"/>
    </form>
    <div id="searchTopResult" class="search-page-result" style="position:fixed; display:none">
        <div class="grid-view" id="searchTopResultItems" style=" display:grid; grid-template-columns:repeat(2, 1fr); gap:10px;"></div>
        <span class="error-search-empty" style="display:none">К сожалению, на ваш поисковый запрос ничего не найдено.</span>
        <div class="btn show-more-search-button js-header-search-all">Показать ещё</div>
    </div>
</div>
<?php

// Инициализация скриптов ?>
<script>
    $(document).ready(function() {
		new DjTopSearchForm();
    });
</script>
