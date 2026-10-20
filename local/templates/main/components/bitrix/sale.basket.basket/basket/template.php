<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** ***********************************************************************
 * Корзина
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * ************************************************************************/

// Проверка корзины на пустоту
if ($arResult['EMPTY_BASKET']) {
	include(\Bitrix\Main\Application::getDocumentRoot() . $templateFolder . '/empty.php');
	return;
}

// Подключаем необходимые скрипты
\CJSCore::Init(array('fx', 'popup', 'ajax'));
\Bitrix\Main\UI\Extension::load(['ui.mustache']);
$this->addExternalJs($this->getFolder() . '/js/action-pool.js');
$this->addExternalJs($this->getFolder() . '/js/filter.js');
$this->addExternalJs($this->getFolder() . '/js/component.js');

// Шаблон ?>
<main class="basket">
	<div class="container">
		<h1 class="page-title page-title--1">Моя корзина</h1>
		<div class="basket__layout" id="basket-root">
			<div class="basket__content">
				<div class="basket__back">

					<div id="basket-items-list-wrapper">
						<div id="basket-items-list-container">
							<div id="basket-items-list-overlay" style="display: none;"></div>
							<div class="basket-items-list" id="basket-item-list">
								<div class="basket-search-not-found" id="basket-item-list-empty-result" style="display: none;">
									<div class="basket-search-not-found-icon"></div>
									<div class="basket-search-not-found-text">По данному запросу товаров не
										найдено
									</div>
								</div>
								<div class="basket__content-list" id="basket-item-table"></div>
							</div>
						</div>
					</div>

					<form class="promocod round-form basket__promocod hidden" id="promocod-form">
                        <div class="round-form__title">Активировать промокод</div>
						<div class="basket-coupon-section">
							<div class="round-form__input">
								<div class="input-group">
									<input type="text" class="input-group__input js-input form-control" id=""  placeholder="Введите промокод или купон" data-entity="basket-coupon-input"/>
									<div class="input-group__hint js-input-hint hidden">
										<span>Неверное значение</span></div>
								</div>
								<?php /*<div class="btn round-btn js-form-submit-btn" style="height:40px;width:40px;min-width:40px;" >
									<span class="btn__label"></span>
									<svg class="btn__icon btn__icon--right" width="16" height="11">
										<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#arrow"></use>
									</svg>
									<div class="btn__loader-icon" style="font-size: 16px;">
                                        <div class="loading-icon js-button-loader"><div></div><div> </div><div></div></div>
                                    </div>
								</div> */?>
							</div>
						</div>
					</form>
					<div class="promocod round-form basket__promocod">
					<?php
					$APPLICATION->IncludeComponent(
						"bitrix:form.result.new",
						"form_call",
						Array(
							"CACHE_TIME" => "3600",
							"CACHE_TYPE" => "A",
							"CHAIN_ITEM_LINK" => "",
							"CHAIN_ITEM_TEXT" => "",
							"EDIT_URL" => "",
							"IGNORE_CUSTOM_TEMPLATE" => "Y",
							"LIST_URL" => "",
							"SEF_MODE" => "N",
							"SUCCESS_URL" => "",
							"USE_EXTENDED_ERRORS" => "Y",
							"VARIABLE_ALIASES" => Array("RESULT_ID"=>"RESULT_ID","WEB_FORM_ID"=>"WEB_FORM_ID"),
							"WEB_FORM_ID" => 1,
                            "ALTER_NAME" => 'Купить в один клик'
						)
					);?>	
					</div>	
                    <div class="promocod__list">
                        <div class="basket-total-promo-block" data-entity="basket-total-promo-block"></div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var promocodeForm = document.getElementById('promocod-form');

                            promocodeForm.addEventListener('keydown', function(event) {
                                if (event.keyCode === 13) { // Enter обновляет страницу и ничего не применяется
                                    event.preventDefault();
                                }
                            });
                        });
                    </script>
					<?php

					// персоналоьные рекомендации (BigData)
					$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
						"AREA_FILE_SHOW" => "file",
						"PATH" => SITE_TEMPLATE_PATH . "/include_areas/catalog/slider-bigdata/include.php"
					));

					// итоговая сумма ?>
					<div class="order-total basket__order-total-tablet">
						<div class="basket-total-block" data-entity="basket-total-block"></div>
					</div>
				</div>
			</div>

			<?php
			if (empty($arResult['ERROR_MESSAGE'])) { ?>
				<div class="basket__summary">
					<div class="order-total order-total--basket basket__order-total">
						<div class="basket-total-block" data-entity="basket-total-block"></div>
					</div>
				</div>
			<?
			if (!empty($arResult['CURRENCIES']) && \Bitrix\Main\Loader::includeModule('currency'))
			{
			CJSCore::Init('currency');

			?>
				<script>
					BX.Currency.setCurrencies(<?=CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true)?>);
				</script>
			<?
			}

			$signer = new \Bitrix\Main\Security\Sign\Signer;
			$signedTemplate = $signer->sign($templateName, 'sale.basket.basket');
			$signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.basket.basket');
			$messages = \Bitrix\Main\Localization\Loc::loadLanguageFile(__FILE__);
			?>
				<script>
					BX.message(<?=CUtil::PhpToJSObject($messages)?>);
					BX.Sale.BasketComponent.init({
						result: <?=CUtil::PhpToJSObject($arResult, false, false, true)?>,
						params: <?=CUtil::PhpToJSObject($arParams)?>,
						template: '<?=CUtil::JSEscape($signedTemplate)?>',
						signedParamsString: '<?=CUtil::JSEscape($signedParams)?>',
						siteId: '<?=CUtil::JSEscape($component->getSiteId())?>',
						siteTemplateId: '<?=CUtil::JSEscape($component->getSiteTemplateId())?>',
						templateFolder: '<?=CUtil::JSEscape($templateFolder)?>'
					});
				</script>
				<?
			} else {
				ShowError($arResult['ERROR_MESSAGE']);
			}
			?>
		</div>
	</div>
</main>
<?php

// Подключаем все js-шаблоны
$jsTemplates = new \Bitrix\Main\IO\Directory(\Bitrix\Main\Application::getDocumentRoot() . $templateFolder . '/js-templates');
foreach ($jsTemplates->getChildren() as $jsTemplate) {
	include($jsTemplate->getPath());
}