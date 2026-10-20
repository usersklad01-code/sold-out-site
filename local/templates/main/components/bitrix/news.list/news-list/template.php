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
	<div class="news-page__catalog">
		<?foreach($arResult['ITEMS'] as $key => $arItem):?>
			<article class="news-item">
				<time class="text-timestamp" datetime="<?=DateTime::createFromFormat('d.m.Y', $arItem['DATE_ACTIVE_FROM'])->format('Y-m-d');?>"><?=FormatDate('j F Y', MakeTimeStamp($arItem["ACTIVE_FROM"]))?></time>
				<h2 class="news-item__title"><?=$arItem['NAME']?></h2>
				<a class="btn btn--medium btn--gray" style="height:36px;width:fit-content;min-width:fit-content;" href="<?=$arItem['DETAIL_PAGE_URL']?>"><span class="btn__label">Читать далее</span></a>
			</article>
		<?endforeach?>
	</div>

	<?if($arResult["NAV_STRING"]):?>
		<?=$arResult["NAV_STRING"];?>
	<?endif?>
<?else:?>
	<div class="news-page__catalog">Ничего не найдено :(</div>
<?endif?>