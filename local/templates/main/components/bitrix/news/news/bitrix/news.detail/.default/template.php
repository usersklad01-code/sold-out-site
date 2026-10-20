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

<main class="news-page">
	<div class="container">
		<div class="content-wrap">
			<div class="content-container content-container--874">
				<div class="news-page__head">
					<a class="btn btn--medium btn--gray"
                       style="height:36px;width:fit-content;min-width:fit-content;"
                       href="<?=$arParams['SECTION_URL']?>"
                    >
                        <span class="btn__label"><?=$arParams['PAGER_TITLE']?></span>
                    </a>
                    <br>
					<div>
						<h1 class="text-page-title text-page-title--1"><?=$arResult['NAME']?></h1>
                        <time class="text-timestamp" datetime="<?=DateTime::createFromFormat('d.m.Y', $arResult['DATE_ACTIVE_FROM'])->format('Y-m-d');?>"><?=FormatDate('j F Y', MakeTimeStamp($arResult["ACTIVE_FROM"]))?></time>

					</div>
				</div>
				<?=$arResult['~DETAIL_TEXT']?>
			</div>

			<?if(count($arResult["SOME_NEWS"]) > 0){?>
				<div class="news-page__catalog">
					<?foreach($arResult["SOME_NEWS"] as $someNew){?>
						<article class="news-item">
                            <time class="text-timestamp" datetime="<?=DateTime::createFromFormat('d.m.Y', $someNew['DATE_ACTIVE_FROM'])->format('Y-m-d');?>"><?=FormatDate('j F Y', MakeTimeStamp($someNew["ACTIVE_FROM"]))?></time>
							<h2 class="news-item__title">
                                <?=$someNew['NAME']?>
                            </h2>
							<a class="btn btn--medium btn--gray" style="height:36px;width:fit-content;min-width:fit-content;" href="<?=$someNew['DETAIL_PAGE_URL']?>">
                                <span class="btn__label">Читать далее</span>
                            </a>
						</article>
					<?}?>
				</div>
			<?}?>

			<?if(!empty($arResult["BANNER"])){?>
				<div class="promo-banner">
					<div class="promo-banner__content">
						<div>
							<div class="promo-banner__title"><?=$arResult["BANNER"]['NAME']?></div>
							<?if(!empty($arResult["BANNER"]['PROPERTY_DESC_VALUE'])){?>
								<div class="promo-banner__text">
                                    <?=$arResult["BANNER"]['PROPERTY_DESC_VALUE']?>
                                </div>
							<?}?>
						</div>

						<?if(!empty($arResult["BANNER"]['PROPERTY_BTN_NAME_VALUE'])){?>
							<a class="btn btn--big promo-banner__button"
                               style="height:45px;width:fit-content;min-width:fit-content;"
                                href="<?=$arResult["BANNER"]['PROPERTY_LINK_VALUE']?:'javascript:void(0)'?>">
								<span class="btn__label"><?=$arResult["BANNER"]['PROPERTY_BTN_NAME_VALUE']?></span>
							</a>
						<?}?>
					</div>
					<img class="promo-banner__img promo-banner__img-desk"
                         src="<?=$arResult["BANNER"]['PREVIEW_PICTURE']['SRC']?>"
                         alt="<?=$arResult["BANNER"]['NAME']?>" loading="lazy"
                    >
					<img class="promo-banner__img promo-banner__img-mob"
                         src="<?=$arResult["BANNER"]['PREVIEW_PICTURE']['SRC']?>"
                         alt="<?=$arResult["BANNER"]['NAME']?>" loading="lazy"
                    >
				</div>
			<?}?>
		</div>
	</div>
</main>