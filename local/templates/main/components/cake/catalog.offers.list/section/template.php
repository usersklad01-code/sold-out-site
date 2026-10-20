<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***********************************************************************************
 * Список торговых предложений
 * @var $arParams
 * @var $arResult
 * @global $APPLICATION
 * ************************************************************************************/
$this->setFrameMode(true); ?>

<div class="catalog-wrap-block">
	<div class="sec-products-catalog__head">
		<?php

		// Кнопка открытия фильтра
		if ($arParams['HIDE_FILTER_BTN'] !== 'Y') { ?>
			<div class="btn btn--big catalog-showfilter js-ct-filter-toggler" style="height:44px;width:fit-content;min-width:fit-content;">
				<svg class="btn__icon btn__icon--left" width="16" height="11">
					<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#filter"></use>
				</svg>
				<span class="btn__label">Все фильтры</span>
				<div class="btn__loader-icon" style="font-size: 16px;">
					<div class="loading-icon js-button-loader">
						<div></div><div></div><div></div>
					</div>
				</div>
			</div>
		<? }

		// Панелька сортировки ?>
		<div class="catalog-sort">
			<form>
				<select class="select js-sort-select sort-select" name="sort">
					<? foreach ($arParams['SORT_VARIANTS'] as $key => $sort) { ?>
						<option <?= $sort['CHECKED'] ? 'selected' : '' ?> value="<?= $key ?>"><?= $sort['NAME'] ?></option>
					<? } ?>
				</select>
			</form>
		</div>
		<?php

		// Панелька переключения вида отображения ?>
		<div class="view-switcher">
			<form style="display: flex">
				<label class="view-switcher__label view-switcher__label--list">
					<input class="view-switcher__input js-view-switcher" type="radio" name="view-switcher" value="list-view" id="list-view" <?= $arParams['VIEW_SWITCHER'] === 'list-view' ? 'checked' : '' ?>>
					<span class="view-switcher__box view-switcher__box--list">
						<svg width="16" height="16">
							<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#list"></use>
						</svg>
					</span>
				</label>
				<label class="view-switcher__label view-switcher__label--grid">
					<input class="view-switcher__input js-view-switcher" type="radio" name="view-switcher" value="grid-view" id="grid-view" <?= $arParams['VIEW_SWITCHER'] === 'grid-view' ? 'checked' : '' ?>>
					<span class="view-switcher__box view-switcher__box--grid">
						<svg width="16" height="16">
							<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#grid"></use>
						</svg>
					</span>
				</label>
			</form>
		</div>
	</div>
	<?php

	// Список товаров ?>
	<div class="sec-products-catalog__list js-catalog-list <?= $arParams['VIEW_SWITCHER'] ?>">
		<? if (is_array($arResult["ITEMS"]) && count($arResult["ITEMS"]) > 0) {
			// Позиция, где выводить баннер
			if ($arResult['PAGEN']["PAGE_NUM"] === 1) {
				$positionBanner = intval(count($arResult["ITEMS"]) / 6) * 3 + 1;
				if ($positionBanner < 4) {
					$positionBanner = 4;
				}
			}

			// выводим плитки товаров и баннер
			foreach ($arResult["ITEMS"] as $i => $itm) {
				// выводим слайдер по середине списка товаров
				if ((--$positionBanner) === 0) {
					$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
						"AREA_FILE_SHOW" => "file",
						"PATH" => SITE_TEMPLATE_PATH . "/include_areas/banner/big-slider.php",
						"SECTION" => "catalog",
						"WRAPPER" => "sec-products-catalog__slider"
					));
				}

				// плитка товара
				$APPLICATION->IncludeComponent(
					'bitrix:catalog.item',
					'sku_card',
					array(
						"RESULT" => array(
							"ITEM" => $itm,
							"PRODUCT" => $arResult["PRODUCTS"][$itm["PRODUCT_ID"]],
							"SECTION" => $arResult["SECTIONS"][$arResult["PRODUCTS"][$itm["PRODUCT_ID"]]["IBLOCK_SECTION_ID"]],
							"AREA_ID" => $this->GetEditAreaId($itm["ID"]),
						),
						"PARAMS" => []
					),
					$this->getComponent(),
					array("HIDE_ICONS" => "Y")
				);
			}
		} else { ?>
			<div class="sec-products-not-found">Товары не найдены. Попробуйте воспользоваться поиском или посмотрите в другом разделе каталога.</div>
		<? } ?>
	</div>
	<?php

	// Постраничка
	echo str_replace("AJAX_REQUEST=Y", "", $arResult["PAGEN"]["NAV_STRING"]);

	// Инициализация скриптов
	$cookiePrefix = \Bitrix\Main\Config\Option::get('main', 'cookie_name', 'BITRIX_SM'); ?>
	<script>
		new DJCatalogList(<?= \Bitrix\Main\Web\Json::encode(array(
			'product_count' => Cake\Tools::cnt2word($arResult["PAGEN"]["TOTAL_COUNT"], ["товар", "товара", "товаров"]),
			'cookie_sort' => $cookiePrefix . '_CATALOG_SORT',
			'cookie_view' => $cookiePrefix . '_CATALOG_VIEW',
		))?>);
	</script>
</div>