<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"]) {
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");?>

<div class="pagination-controls">
	<div class="pagination">
		<?if ($arResult["NavPageNomer"] > 1):?>
			<?if($arResult["bSavePage"]):?>
				<a class="pagination__button pagination__button-prev" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">
					<svg class="pagination__button-icon" width="20" height="10">
						<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-small"></use>
					</svg>
				</a>
			<?else:?>
				<?if ($arResult["NavPageNomer"] > 2):?>
					<a class="pagination__button pagination__button-prev" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">
						<svg class="pagination__button-icon" width="20" height="10">
							<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-small"></use>
						</svg>
					</a>
				<?else:?>
					<a class="pagination__button pagination__button-prev" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
						<svg class="pagination__button-icon" width="20" height="10">
							<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-small"></use>
						</svg>
					</a>
				<?endif?>
			<?endif?>
		<?endif?>

		<ul class="pagination__list">
			<?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>
				<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
					<li class="pagination__item is-active"><a class="pagination__number"><?=$arResult["nStartPage"]?></a></li>&nbsp;
				<?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
					<li class="pagination__item"><a class="pagination__number" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a></li>

				<?else:?>
					<li class="pagination__item"><a class="pagination__number" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a></li>
				<?endif?>
				<?$arResult["nStartPage"]++?>
			<?endwhile?>
		</ul>

		<?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
			<a class="pagination__button pagination__button-next" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">
				<svg class="pagination__button-icon" width="20" height="10">
					<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-small"></use>
				</svg>
			</a>
		<?endif?>
	</div>
</div>

<script>
    $(document).ready(function() {
        $('.pagination__number').on('click', function(){

            $('html,body').animate({
                scrollTop: $('.catalog-wrap-block').offset().top + "px"
            }, {
                duration: 800,
                easing: "linear"
            });
        });

    });
</script>
