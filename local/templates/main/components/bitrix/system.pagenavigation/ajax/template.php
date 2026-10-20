<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);

if (!$arResult["NavShowAlways"]) {
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
        return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : ""); ?>

<div class="pagination-controls js-pagination">
    <? if ($arResult["NavPageNomer"] + 1 <= $arResult["NavPageCount"]) { ?>
        <a class="btn btn--big" style="height:41px;width:fit-content;min-width:fit-content;"
           type="button"
           href=""
           data-href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"
		   data-append="y"
        >
            <span class="btn__label">Показать еще</span>
            <div class="btn__loader-icon" style="font-size: 16px;">
				<div class="loading-icon js-button-loader">
					<div></div>
					<div> </div>
					<div></div>
				</div>
			</div>
        </a>
    <? } ?>
    <div class="pagination">
        <? if ($arResult["NavPageNomer"] > 1) { ?>
            <? if ($arResult["bSavePage"]) { ?>
                <a class="pagination__button pagination__button-prev"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"
                >
                    <svg class="pagination__button-icon" width="20" height="10">
                        <use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-small"></use>
                    </svg>
                </a>
            <? } else { ?>
                <? if ($arResult["NavPageNomer"] > 2) { ?>
                    <a class="pagination__button pagination__button-prev"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"
                    >
                        <svg class="pagination__button-icon" width="20" height="10">
                            <use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-small"></use>
                        </svg>
                    </a>
                <? } else { ?>
                    <a class="pagination__button pagination__button-prev"
                       href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"
                    >
                        <svg class="pagination__button-icon" width="20" height="10">
                            <use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-small"></use>
                        </svg>
                    </a>
                <? } ?>
            <? } ?>
        <? } ?>

        <ul class="pagination__list">
            <? while ($arResult["nStartPage"] <= $arResult["nEndPage"]) { ?>
                <? if ($arResult["nStartPage"] == $arResult["NavPageNomer"]) { ?>
                    <li class="pagination__item is-active">
                        <a class="pagination__number">
                            <?= $arResult["nStartPage"] ?>
                        </a>
                    </li>
                <? } elseif ($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false) { ?>
                    <li class="pagination__item">
                        <a class="pagination__number" href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">
                            <?= $arResult["nStartPage"] ?>
                        </a>
                    </li>
                <? } else { ?>
                    <li class="pagination__item">
                        <a class="pagination__number"
                           href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"
                        >
                            <?= $arResult["nStartPage"] ?>
                        </a>
                    </li>
                <? } ?>
                <? $arResult["nStartPage"]++ ?>
            <? } ?>
        </ul>

        <? if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) { ?>
            <a class="pagination__button pagination__button-next"
               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"
            >
                <svg class="pagination__button-icon" width="20" height="10">
                    <use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#tail-arrow-small"></use>
                </svg>
            </a>
        <? } ?>
    </div>
</div>