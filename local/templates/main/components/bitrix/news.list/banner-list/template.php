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
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<div class="promo-banner promo-banner--centered-content">
			<div class="promo-banner__content">
				<div>
					<div class="promo-banner__title"><?=$arItem['NAME']?></div>
					<?if(!empty($arItem["PROPERTIES"]['DESC']['VALUE'])):?>
						<div class="promo-banner__text"><?=$arItem["PROPERTIES"]['DESC']['VALUE']?></div>
					<?endif?>
				</div>

				<?if(!empty($arItem['PROPERTIES']['BTN_NAME']['VALUE'])):?>
					<a class="btn btn--big promo-banner__button" style="height:45px;width:fit-content;min-width:fit-content;"<?if(!empty($arItem['PROPERTIES']['LINK']['VALUE'])):?> href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>"<?endif?>>
						<span class="btn__label"><?=$arItem['PROPERTIES']['BTN_NAME']['VALUE']?></span>
					</a>
				<?endif?>
			</div>
			<img class="promo-banner__img promo-banner__img-desk" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>" loading="lazy">
			<img class="promo-banner__img promo-banner__img-mob" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>" loading="lazy">
		</div>
	<?endforeach?>
<?endif?>