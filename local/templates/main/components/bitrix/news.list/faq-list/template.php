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

$this->setFrameMode(true);?>

<?if(count($arResult['ITEMS']) > 0):?>
	<div class="faq-block">
		<h2 class="faq-block__head">Часто задаваемые вопросы</h2>
		<div class="faq-block__container">
			<div class="faq-block__container-col">
				<?foreach($arResult['ITEMS'] as $key => $arItem):?>
					<?if(($key + 1) % 2 == 1):?>
						<div class="faq-block__collapsible-block collapsible-block js-collapsible-block">
							<button class="faq-block__collapsible-btn js-collapsible-toggler" type="button">
								<span><?=$arItem['NAME']?></span>
								<svg class="js-collapsible-icon" width="16" height="8">
									<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#bold-arrow-down"></use>
								</svg>
							</button>
							<div class="faq-block__collapsible-content collapsible-block__content js-collapsible-content">
								<?=$arItem['~PREVIEW_TEXT']?>
							</div>
						</div>
					<?endif?>
				<?endforeach?>
			</div>
			<div class="faq-block__container-col">
				<?foreach($arResult['ITEMS'] as $key => $arItem):?>
					<?if(($key + 1) % 2 == 0):?>
						<div class="faq-block__collapsible-block collapsible-block js-collapsible-block">
							<button class="faq-block__collapsible-btn js-collapsible-toggler" type="button">
								<span><?=$arItem['NAME']?></span>
								<svg class="js-collapsible-icon" width="16" height="8">
									<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#bold-arrow-down"></use>
								</svg>
							</button>
							<div class="faq-block__collapsible-content collapsible-block__content js-collapsible-content">
								<?=$arItem['~PREVIEW_TEXT']?>
							</div>
						</div>
					<?endif?>
				<?endforeach?>
			</div>
		</div>
	</div>
<?endif?>