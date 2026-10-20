<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//***********************************
//setting section
//***********************************
global $USER;
?>
<form id="notificationForm" name="notification-form" action="<?=$arResult["FORM_ACTION"]?>" method="post">
    <input type="hidden" name="PostAction" value="<?= ($arResult["ID"]>0? "Update":"Add")?>" />
    <input type="hidden" name="ID" value="<?= $arResult["SUBSCRIPTION"]["ID"];?>" />
    <?if($_REQUEST["register"] == "YES"){?>
        <input type="hidden" name="register" value="YES" />
    <?}?>
    <?if($_REQUEST["authorize"]=="YES"){?>
        <input type="hidden" name="authorize" value="YES" />
    <?}?>
    <?= bitrix_sessid_post();?>
    <input type="hidden" name="EMAIL"
           value="<?=$USER->GetEmail();?>"
           size="30" maxlength="255" />
    <input type="hidden" name="FORMAT" value="html" checked />
    <input type="hidden" name="Save"
           value="<?= ($arResult["ID"] > 0? GetMessage("subscr_upd"):GetMessage("subscr_add"))?>" />
    <div class="pc-notifications">
		<?foreach($arResult["RUBRICS"] as $itemID => $itemValue){?>
            <div class="checkbox-filter">
                <label class="checkbox-filter__label">
                    <input class="checkbox-filter__input js-checkbox-filter js-price-checkbox" type="checkbox"
                           name="RUB_ID[]" value="<?=$itemValue["ID"]?>"<?=$itemValue["CHECKED"]?" checked":''?> />
                    <span class="checkbox-filter__box"></span>
                    <span class="checkbox-filter__text">
                        <?=$itemValue["NAME"]?>
                    </span>
                </label>
            </div>
		<?}?>
    </div>
</form>

