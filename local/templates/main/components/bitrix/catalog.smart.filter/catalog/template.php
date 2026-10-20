<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** ***************************************************************************
 * Шаблон фильтра в каталоге
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * ****************************************************************************/
use Bitrix\Iblock\SectionPropertyTable;
$this->setFrameMode(true); ?>

<div class="ct-filter js-ct-filter" id="catalog-filter">
	<div class="ct-filter__overlay js-ct-filter-toggler"></div>
	<div class="ct-filter__wrapper">
		<div class="ct-filter__body">
			<?php

			// Мобильная кнопка отображения фильтра ?>
			<div class="ct-filter__head">
				<span>Фильтры</span>
				<button class="icon-button js-ct-filter-toggler" type="button">
					<svg width="14" height="14">
						<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#cross"></use>
					</svg>
				</button>
			</div>
			<?php

			// Форма фильтра ?>
			<form class="ct-filter__form js-ct-filter-form smartfilter" name="<?= $arResult["FILTER_NAME"] . "_form" ?>" action="<?= $arResult["FORM_ACTION"] ?>" method="get" novalidate>
				<?php

				// скрытые поля
				foreach ($arResult["HIDDEN"] as $arItem) { ?>
					<input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>" value="<? echo $arItem["HTML_VALUE"] ?>"/>
				<? }

				// Количество и кнопка очистки фильтров ?>
				<fieldset class="ct-filter__fieldset">
					<label class="ct-filter__label" id="modef_num" style="display:none;"><?= intval($arResult["ELEMENT_COUNT"]) ?> товаров</label>
					<div class="ct-filter__content">
						<? if ($_REQUEST['set_filter']) {
							$url = $arParams['SEF_URL_TEMPLATES']['base'] . $arParams['SEF_URL_TEMPLATES']['section']; ?>
							<a class="btn btn--gray js-reset-filter" href="<?= $url ?>/" type="button" data-for="all">
								<span class="btn__label">Очистить все фильтры</span>
								<svg class="btn__icon btn__icon--right" width="16" height="11">
									<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#cross"></use>
								</svg>
								<div class="btn__loader-icon">
									<div class="loading-icon js-button-loader"><div></div><div> </div><div></div></div>
								</div>
							</a>
						<? } ?>
                        <?php
                        foreach ($arResult["ITEMS"] as $arItem) {
                            foreach ($arItem["VALUES"] as $arIt) {
                                if ($arIt["CHECKED"] == 1) { ?>
                                    <?$currentUrl = $_SERVER['REQUEST_URI'];
                                    $urlParts = parse_url($currentUrl);
                                    parse_str($urlParts['query'], $query);
                                    unset($query[$arIt['CONTROL_ID']]);
                                    $newQuery = http_build_query($query);
                                    $updatedUrl = $urlParts['path'] . ($newQuery ? '?' . $newQuery : '');?>
                                    <a class="btn btn--gray js-reset-filter" href="<?= $updatedUrl ?>" type="button" data-for="all">
                                        <span class="btn__label"><?= $arIt['VALUE'] ?></span>
                                        <svg class="btn__icon btn__icon--right" width="16" height="11">
                                            <use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#cross"></use>
                                        </svg>
                                        <div class="btn__loader-icon">
                                            <div class="loading-icon js-button-loader"><div></div><div> </div><div></div></div>
                                        </div>
                                    </a>
                                    <?
                                }
                            }
                        }
                        ?>

                    </div>

				</fieldset>
				<?php

				// Выводим цену
				foreach ($arResult["ITEMS"] as $arItem) {
					// Если не цена - пропускаем
					if (!isset($arItem["PRICE"]) || $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0) {
						continue;
					}

					// Подготавливаем параметры
					$key = $arItem["ENCODED_ID"];
					$step_num = 4;
					$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
					$prices = array();
					for ($i = 0; $i < $step_num; $i++) {
						$prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i, 0, ".", "");
					}
					$prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], 0, ".", "");

					// Выводим фильтр по цене ?>
					<fieldset class="ct-filter__fieldset">
						<span class="bx-filter-container-modef"></span>
						<label class="ct-filter__label">Цена</label>
						<div class="ct-filter__content" data-role="bx_filter_block">
							<div class="ct-filter__range-group range-group js-range-group">
								<div class="ui-range-slider js-range-slider" data-type-range="double"></div>
								<div class="range-group__inputs">
									<div class="ui-input-price">
										<span class="ui-input-price__prefix">от</span>
										<input class="min-price" type="hidden" value=""  onkeyup="smartFilter.keyup(this)"/>
										<input class="ui-input-price__input js-input-min" type="text"
											   name="<?= $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
											   id="<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
											   value="<?= $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?: $arItem["VALUES"]["MIN"]["VALUE"] ?>"
											   data-range-input="min" data-min="<?= $arItem["VALUES"]["MIN"]["VALUE"] ?>"
											   autocomplete="off" data-for="price-min">
										<span class="ui-input-price__postfix">₽</span>
									</div>
									<div class="ui-input-price">
										<span class="ui-input-price__prefix">до</span>
										<input class="max-price" type="hidden" value=""  onkeyup="smartFilter.keyup(this)"/>
										<input class="ui-input-price__input js-input-max" type="text"
											   name="<?= $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
											   id="<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
											   value="<?= $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?: $arItem["VALUES"]["MAX"]["VALUE"] ?>"
											   data-range-input="max" data-max="<?= $arItem["VALUES"]["MAX"]["VALUE"] ?>" autocomplete="off"
											   data-for="price-max">
										<span class="ui-input-price__postfix">₽</span>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
				<?php

				// Инициализируем js для цены ?>
					<script type="text/javascript">
						BX.ready(function () {
							window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject(array(
								"leftSlider" => 'left_slider_' . $key,
								"rightSlider" => 'right_slider_' . $key,
								"tracker" => "drag_tracker_" . $key,
								"trackerWrap" => "drag_track_" . $key,
								"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
								"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
								"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
								"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
								"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
								"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
								"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"],
								"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
								"precision" => 0,
								"colorUnavailableActive" => 'colorUnavailableActive_' . $key,
								"colorAvailableActive" => 'colorAvailableActive_' . $key,
								"colorAvailableInactive" => 'colorAvailableInactive_' . $key,
							))?>);
						});
					</script>
				<? }

				// Остальные параметры
				foreach ($arResult["ITEMS"] as $key => $arItem) {
					// Незаполненные параметры и цену пропускаем
					if (empty($arItem["VALUES"]) || isset($arItem["PRICE"]) || ($arItem["DISPLAY_TYPE"] === SectionPropertyTable::NUMBERS_WITH_SLIDER && $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)) {
						continue;
					}

					// Выводим параметр фильтра ?>
					<fieldset class="ct-filter__fieldset ct-filter__fieldset--collapsible collapsible-block js-collapsible-fieldset">
						<span class="bx-filter-container-modef"></span>
						<? $arCur = current($arItem["VALUES"]);
						switch ($arItem["DISPLAY_TYPE"]) {

							// Числа выводим как слайдер (по аналогии с ценой)
							case SectionPropertyTable::NUMBERS:
							case SectionPropertyTable::NUMBERS_WITH_SLIDER: { ?>
								<div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
									<i class="bx-ft-sub">От</i>
									<div class="bx-filter-input-container">
										<input class="min-price" type="text" name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>" id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>" value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>" size="5" onkeyup="smartFilter.keyup(this)"/>
									</div>
								</div>
								<div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
									<i class="bx-ft-sub">До</i>
									<div class="bx-filter-input-container">
										<input class="max-price" type="text" name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>" id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>" value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>" size="5" onkeyup="smartFilter.keyup(this)"/>
									</div>
								</div>
								<div class="col-xs-10 col-xs-offset-1 bx-ui-slider-track-container">
									<div class="bx-ui-slider-track" id="drag_track_<?= $key ?>">
										<? $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
										$value1 = number_format($arItem["VALUES"]["MIN"]["VALUE"], 0, ".", "");
										$value2 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step, 0, ".", "");
										$value3 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 2, 0, ".", "");
										$value4 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 3, 0, ".", "");
										$value5 = number_format($arItem["VALUES"]["MAX"]["VALUE"], 0, ".", ""); ?>
										<div class="bx-ui-slider-part p1"><span><?= $value1 ?></span></div>
										<div class="bx-ui-slider-part p2"><span><?= $value2 ?></span></div>
										<div class="bx-ui-slider-part p3"><span><?= $value3 ?></span></div>
										<div class="bx-ui-slider-part p4"><span><?= $value4 ?></span></div>
										<div class="bx-ui-slider-part p5"><span><?= $value5 ?></span></div>
										<div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?= $key ?>"></div>
										<div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?= $key ?>"></div>
										<div class="bx-ui-slider-pricebar-v" style="left: 0;right: 0;" id="colorAvailableActive_<?= $key ?>"></div>
										<div class="bx-ui-slider-range" id="drag_tracker_<?= $key ?>" style="left: 0;right: 0;">
											<a class="bx-ui-slider-handle left" style="left:0;" href="javascript:void(0)" id="left_slider_<?= $key ?>"></a>
											<a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?= $key ?>"></a>
										</div>
									</div>
								</div>
								<script type="text/javascript">
									BX.ready(function () {
										window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject(array(
											"leftSlider" => 'left_slider_' . $key,
											"rightSlider" => 'right_slider_' . $key,
											"tracker" => "drag_tracker_" . $key,
											"trackerWrap" => "drag_track_" . $key,
											"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
											"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
											"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
											"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
											"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
											"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
											"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"],
											"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
											"precision" => 0,
											"colorUnavailableActive" => 'colorUnavailableActive_' . $key,
											"colorAvailableActive" => 'colorAvailableActive_' . $key,
											"colorAvailableInactive" => 'colorAvailableInactive_' . $key,
										))?>);
									});
								</script>
								<? break;
							}

						// Все остальное выводим как набор чекбоксов
							case SectionPropertyTable::CHECKBOXES_WITH_PICTURES:
							case SectionPropertyTable::CHECKBOXES_WITH_PICTURES_AND_LABELS:
							case SectionPropertyTable::DROPDOWN:
							case SectionPropertyTable::DROPDOWN_WITH_PICTURES_AND_LABELS:
							case SectionPropertyTable::RADIO_BUTTONS:
							case SectionPropertyTable::CHECKBOXES: { ?>
								<button class="ct-filter__collapsible-btn js-toggler active" type="button">
									<span class="ct-filter__label"><?= $arItem['NAME'] ?></span>
									<svg class="js-collapsible-icon" width="16" height="8">
										<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#bold-arrow-down"></use>
									</svg>
								</button>
								<div class="ct-filter__fieldset-content js-content" data-parent-container style="display: none">
									<div class="ct-filter__checkbox-group js-more-items" data-visible="5">
										<? foreach ($arItem["VALUES"] as $val => $ar) { ?>
                                            <div class="js-more-item">
                                                <div class="checkbox-filter" style="<?= $ar["DISABLED"] ? 'opacity: 0.5;' : '' ?>">
                                                    <label class="checkbox-filter__label" data-role="label_<?= $ar["CONTROL_ID"] ?>" for="<?= $ar["CONTROL_ID"] ?>">
                                                        <input class="checkbox-filter__input js-checkbox-filter"
                                                               type="checkbox"
                                                               value="<?= $ar["HTML_VALUE"] ?>"
                                                               name="<?= $ar["CONTROL_NAME"] ?>"
                                                               id="<?= $ar["CONTROL_ID"] ?>"
                                                            <?= $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                               onclick="smartFilter.click(this)"
                                                            <?= $ar["DISABLED"] ? 'disabled' : '' ?>
                                                        />
                                                        <span class="checkbox-filter__box" style="<?= $ar["DISABLED"] ? 'opacity: 0.5;' : '' ?>"></span>
                                                        <span class="checkbox-filter__text" style="<?= $ar["DISABLED"] ? 'color: gray;' : '' ?>"><?= $ar["VALUE"] ?>
							<?
										if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
											?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
										endif;?>
							</span>
                                                    </label>
                                                </div>
                                            </div>
										<? } ?>
									</div>
									<button class="btn link-button ct-filter__show-more js-toggle-btn" type="button" data-title="Посмотреть еще"></button>
								</div>
								<? break;
							}

							// Остальное - пропускаем
							default:
								continue;
						} ?>
					</fieldset>
				<? }


				// Кнопки применения фильтра ?>
				<!--<input class="btn btn-themes" type="submit" id="set_filter" name="set_filter" value="Показать" />-->
				<div class="ct-filter__bottom">
					<div class="bx-filter-popup-result" id="modef" <?echo (!isset($arResult["ELEMENT_COUNT"])) ? 'style="display:none;"' : 'style="display:inline-block;"'; ?>>
						<a href="<?= $arResult["FILTER_URL"] ?>" >Показать</a>
					</div>
					<div class="btn ct-filter__submit-btn js-button" style="height:36px;width:fit-content;min-width:fit-content;">
                        <span class="btn__label">
                        	<input class="btn btn-themes" type="submit" id="set_filter" name="set_filter" value="Показать" />
                        </span>
						<div class="btn__loader-icon">
                        	<div class="loading-icon js-button-loader"><div></div><div> </div><div></div></div>
                        </div>
					</div>
					<div class="ct-filter__reset js-reset-form">
                        <span class="ct-filter__reset-text ct-filter__reset-text--desc">
                            <input class="btn btn-link" type="submit" id="del_filter" name="del_filter" value="Сбросить фильтр" />
                        </span>

					</div>
				</div>
			<div class="bx_filter_popup_result <?=$arParams["POPUP_POSITION"]?>" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
							<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
							<span class="arrow"></span>
							<a href="<?echo $arResult["FILTER_URL"]?>"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
			</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>