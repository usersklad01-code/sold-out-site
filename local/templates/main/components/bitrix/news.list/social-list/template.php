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
	<ul class="footer-socials list-style-none">
		<?foreach($arResult['ITEMS'] as $key => $arItem):?>
			<li class="footer-socials__item">
				<a<?if(!empty($arItem['PROPERTIES']['LINK']['VALUE'])):?> href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>"<?endif?> target="_blank" title="<?=$arItem['NAME']?>">
					<img src="<?=$arItem['DISPLAY_PROPERTIES']['ICON']['FILE_VALUE']['SRC']?>" alt="<?=$arItem['NAME']?>">
				</a>
			</li>
		<?endforeach?>
	</ul>
<?endif?>