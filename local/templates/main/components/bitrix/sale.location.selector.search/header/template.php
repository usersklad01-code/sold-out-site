<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Выбор местоположения
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * ***************************************************************************/


// Плашка текущего местоположения ?>
<div class="header__loc" data-entity="location">
	<a class="header__loc-link js-show-popup" role="button" href="javascript:void(0)" data-popup="popup-location" data-open-modal="select-city">
		<span><?= $arResult['LOCATION']['NAME'] ?: 'Город' ?></span>
		<svg width="10" height="8">
			<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#arrow-menu"></use>
		</svg>
	</a>
</div>
<?php


// Мобильная плашка текущего местоположения
$this->SetViewTarget('mobileLocation'); ?>
	<div class="mob-menu__loc">
		<a class="mob-menu__loc-link js-show-popup" role="button" href="#" data-popup="popup-location" data-open-modal="select-city">
			<span><?= $arResult['LOCATION']['NAME'] ?></span>
			<svg width="10" height="8">
				<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#arrow-menu"></use>
			</svg>
		</a>
		<? if ($arResult['LOCATION']['NAME'] == 'Санкт-Петербург') { ?>
			<span><? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/include_areas/footer/address.html"); ?></span>
		<? } ?>
	</div>
<? $this->EndViewTarget();


// Местоположение в подвале
$this->SetViewTarget('footerLocation'); ?>
	<div class="header__loc" data-entity="location">
		<a class="header__loc-link js-show-popup" role="button" href="javascript:void(0)" data-popup="popup-location" data-open-modal="select-city">
			<span><?= $arResult['LOCATION']['NAME'] ?: 'Город' ?></span>
			<svg width="10" height="8">
				<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#arrow-menu"></use>
			</svg>
		</a>
		<? if ($arResult['LOCATION']['NAME'] == 'Санкт-Петербург') { ?>
			<span><? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/include_areas/footer/address.html"); ?></span>
		<? } ?>
	</div>
<? $this->EndViewTarget();?>


<?$this->SetViewTarget('modalLocation'); ?>
<div class="modal modal--preload modal--popup modal--ordinary city-popup" data-modal="select-city">
	<div class="modal__wrapper">
		<div class="modal__overlay" data-close-modal></div>
		<div class="modal__content">
			<div class="modal-select-sity">
				<h2 class="modal-select-sity__title">Укажите свой город</h2>
				<? if (!empty($arResult['ERRORS']['FATAL'])) {
					foreach ($arResult['ERRORS']['FATAL'] as $error) {
						ShowError($error);
					}
				} else {
					// Форма выбора ?>
					<form class="modal-select-sity__form search-line-form">
						<div id="sls-<?= $arResult['RANDOM_TAG'] ?>" class="bx-sls" style="position:relative;">
							<? // Поле ввода ?>
							<div class=" bx-ui-sls-input-block search-line-form__input">
								<span class="dropdown-icon"></span>
								<input type="text" autocomplete="off" name="<?= $arParams['INPUT_NAME'] ?>" value="<?= $arResult['VALUE'] ?>" class="dropdown-field search-line-form__input" placeholder="Ваш город"/>
								<div class="bx-ui-sls-loader"></div>
								<div class="bx-ui-sls-clear" title="Отменить выбор"></div>
								<div class="bx-ui-sls-pane"></div>
							</div>
							<? // Шаблон сообщения ?>
							<script type="text/html" data-template-id="bx-ui-sls-error">
								<div class="bx-ui-sls-error">
									<div></div>
									{{message}}
								</div>
							</script>
							<? // Шаблон пункта выпадающего списка ?>
							<script type="text/html" data-template-id="bx-ui-sls-dropdown-item">
								<div class="dropdown-item bx-ui-sls-variant" data-delivery-id="20">
									<span class="dropdown-item-text">{{display_wrapped}}</span>
								</div>
							</script>
							<? // Шаблон сообщения об ошибке ?>
							<div class="bx-ui-sls-error-message">
								<? if (!$arParams['SUPPRESS_ERRORS']) {
									if (!empty($arResult['ERRORS']['NONFATAL'])) {
										foreach ($arResult['ERRORS']['NONFATAL'] as $error) {
											ShowError($error);
										}
									}
								} ?>
							</div>
						</div>
					</form>
					<?php

					// Список избранных городов ?>
					<ul class="modal-select-sity__list">
						<? foreach ($arResult['FAVORITE_CITIES'] as $id => $name) { ?>
                        <noindex>
							<li>
								<div class="modal-select-sity__link js-select-city <?= $arResult['LOCATION']['ID'] == $id ? 'is-current' : '' ?>" style="cursor:pointer" data-current-city-id="<?= $id ?>" >
									<?= $name ?>
								</div>
							</li>
                        </noindex>
						<? } ?>
					</ul>
					<?php

					// Подключение скриптов
					CJSCore::Init();
					$asset = \Bitrix\Main\Page\Asset::getInstance();
					$asset->addJs('/bitrix/js/sale/core_ui_widget.js');
					$asset->addJs('/bitrix/js/sale/core_ui_etc.js');
					$asset->addJs('/bitrix/js/sale/core_ui_autocomplete.js'); ?>
					<script>
						if (!window.BX && top.BX) {
							window.BX = top.BX;
						}
						if (typeof window.BX.locationSelectors == 'undefined') {
							window.BX.locationSelectors = {};
						}
						window.BX.locationSelectors['<?=$arParams['JS_CONTROL_GLOBAL_ID']?>'] = new BX.Sale.component.location.selector.search(<?=CUtil::PhpToJSObject(array(
							// common
							'scope' => 'sls-' . $arResult['RANDOM_TAG'],
							'source' => $this->__component->getPath() . '/get.php',
							'query' => array(
								'FILTER' => array(
									'EXCLUDE_ID' => intval($arParams['EXCLUDE_SUBTREE']),
									'SITE_ID' => $arParams['FILTER_BY_SITE'] && !empty($arParams['FILTER_SITE_ID']) ? $arParams['FILTER_SITE_ID'] : ''
								),
								'BEHAVIOUR' => array(
									'SEARCH_BY_PRIMARY' => $arParams['SEARCH_BY_PRIMARY'] ? '1' : '0',
									'LANGUAGE_ID' => LANGUAGE_ID
								),
							),
							'selectedItem' => !empty($arResult['LOCATION']) ? $arResult['LOCATION']['VALUE'] : false,
							'knownItems' => $arResult['KNOWN_ITEMS'],
							'provideLinkBy' => $arParams['PROVIDE_LINK_BY'],
							'messages' => array(
								'nothingFound' => 'К сожалению, ничего не найдено',
								'error' => 'К сожалению, произошла внутренняя ошибка',
							),
							// "js logic"-related part
							'callback' => $arParams['JS_CALLBACK'],
							'useSpawn' => $arParams['USE_JS_SPAWN'] == 'Y',
							'initializeByGlobalEvent' => $arParams['INITIALIZE_BY_GLOBAL_EVENT'],
							'globalEventScope' => $arParams['GLOBAL_EVENT_SCOPE'],
							// specific
							'pathNames' => $arResult['PATH_NAMES'],
							// deprecated
							'types' => $arResult['TYPES'],
						), false, false, true)?>);
					</script>
				<? } ?>
			</div>
			<button class="modal__close-btn" type="button" aria-label="Закрыть попап" data-close-modal>
				<svg width="16" height="16">
					<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#cross"></use>
				</svg>
			</button>
		</div>
	</div>
</div>
<? $this->EndViewTarget();?>