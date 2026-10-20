<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */



/*if($arResult["SHOW_SMS_FIELD"] == true)
{
    CJSCore::Init('phone_auth');
}*/
?>
<?ShowError($arResult["strProfileError"]);?>

<?
if ($arResult['DATA_SAVED'] == 'Y')
    ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>

<div class="personal-data">
    <div class="form tile__form is-active" data-entity="personal-data">
        <div class="personal-data__list">
            <div class="personal-data__row">
                <div class="personal-data__term">ФИО</div>
                <div class="personal-data__desk"><?=$arResult["arUser"]["LAST_NAME"]?> <?=$arResult["arUser"]["NAME"]?> <?=$arResult["arUser"]["SECOND_NAME"]?></div>
            </div>

            <?if(!empty($arResult["arUser"]["PERSONAL_STREET"])):?>
                <div class="personal-data__row">
                    <div class="personal-data__term">Адрес</div>
                    <div class="personal-data__desk"><?=$arResult["arUser"]["PERSONAL_CITY"]?>, <?=$arResult["arUser"]["PERSONAL_STREET"]?></div>
                </div>
            <?endif?>

            <?if(!empty($arResult["arUser"]["EMAIL"])):?>
                <div class="personal-data__row">
                    <div class="personal-data__term">Email</div>
                    <div class="personal-data__desk"><?=$arResult["arUser"]["EMAIL"]?></div>
                </div>
            <?endif?>
            <button class="btn btn--medium btn--gray personal-data__btn" style="height:54px;width:fit-content;min-width:fit-content;" height="54px" type="button"
                data-action="change"
            >
                <span class="btn__label">Изменить</span>
                <span class="btn__loader-icon" style="font-size: 16px;">
                    <div class="loading-icon js-button-loader">
                        <div></div>
                        <div> </div>
                        <div></div>
                    </div>
                </span>
            </button>
        </div>
    </div>
	<form class="order__form-block form-order is-fade" data-entity="personal-change" id="user-edit-form"
          method="post" enctype="multipart/form-data" action="<?=$arResult["FORM_TARGET"]?>" >
        <?=$arResult["BX_SESSION_CHECK"]?>
        <input type="hidden" name="lang" value="<?=LANG?>" />
        <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />

        <fieldset>
            <h2 class="form-order__title">Персональные данные</h2>
            <div class="input-group">
                <input class="input-group__input js-input casual-input" type="text" name="NAME" maxlength="50"
                       value="<?=$arResult["arUser"]["NAME"]?>" placeholder="Имя" />
                <div class="input-group__hint js-input-hint hidden"><span>Неверное значение</span></div>
            </div>
            <div class="input-group">
                <input class="input-group__input js-input casual-input" type="text" name="LAST_NAME" maxlength="50"
                       value="<?=$arResult["arUser"]["LAST_NAME"]?>" placeholder="Фамилия" />
                <div class="input-group__hint js-input-hint hidden"><span>Неверное значение</span></div>
            </div>
            <div class="input-group">
                <input class="input-group__input js-input casual-input" type="text" name="SECOND_NAME" maxlength="50"
                       value="<?=$arResult["arUser"]["SECOND_NAME"]?>" placeholder="Отчество" />
                <div class="input-group__hint js-input-hint hidden"><span>Неверное значение</span></div>
            </div>
            <div class="input-group">
                <input class="input-group__input js-input casual-input" type="text" name="LOGIN" maxlength="50"
                       value="<?=$arResult["arUser"]["LOGIN"]?>" placeholder="Логин" />
                <div class="input-group__hint js-input-hint hidden"><span>Неверное значение</span></div>
            </div>
            <div class="input-group">
                <input class="input-group__input js-input casual-input" type="email" name="EMAIL" maxlength="50"
                       value="<?=$arResult["arUser"]["EMAIL"]?>" placeholder="Почта" />
                <div class="input-group__hint js-input-hint hidden"><span>Неверное значение</span></div>
            </div>
            <div class="input-group">
                <input class="input-group__input js-input casual-input" type="text" name="PERSONAL_CITY" maxlength="50"
                       value="<?=$arResult["arUser"]["PERSONAL_CITY"]?>"
                       placeholder="Город" />
                <div class="input-group__hint js-input-hint hidden"><span>Неверное значение</span></div>
            </div>
            <div class="input-group">
                <input class="input-group__input js-input casual-input" type="text" name="PERSONAL_STREET" maxlength="50"
                       value="<?=$arResult["arUser"]["PERSONAL_STREET"]?>"
                       placeholder="Точный адрес" />
                <div class="input-group__hint js-input-hint hidden"><span>Неверное значение</span></div>
            </div>


            <?if($arResult["PHONE_REGISTRATION"]){?>
                <div class="input-group">
                    <input class="input-group__input js-input casual-input" type="text" name="PHONE_NUMBER" maxlength="50"
                           value="<?= $arResult["arUser"]["PHONE_NUMBER"]?>" placeholder="Телефон" />
                    <div class="input-group__hint js-input-hint hidden"><span>Неверное значение</span></div>
                </div>
            <?}?>


            <?if($arResult['CAN_EDIT_PASSWORD']){?>
                <div class="input-group">
                    <input class="input-group__input js-input casual-input" type="password" name="NEW_PASSWORD"
                           maxlength="50" value="" autocomplete="off" placeholder="Пароль" />
                    <div class="input-group__hint js-input-hint hidden"><span>Неверное значение</span></div>
                </div>
                <?if($arResult["SECURE_AUTH"]){?>
                    <span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				    </span>
                    <noscript>
                        <span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
                            <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                        </span>
                    </noscript>
                    <script type="text/javascript">
                        document.getElementById('bx_auth_secure').style.display = 'inline-block';
                    </script>
                <?}?>
                <div class="input-group">
                    <input class="input-group__input js-input casual-input" type="password" name="NEW_PASSWORD_CONFIRM"
                           maxlength="50" placeholder="Подтверждение пароля" value="" autocomplete="off"/>
                    <div class="input-group__hint js-input-hint hidden"><span>Неверное значение</span></div>
                </div>
            <?}?>
        </fieldset>
        <div class="order-total-btns">
            <button class="btn btn--big" style="height: 54px; width: fit-content; min-width: fit-content;"
                    type="submit" name="save" value="Сохранить"
            >
                <span class="btn__label">Сохранить</span>
                <span class="btn__loader-icon" style="font-size: 16px;">
								  <div class="loading-icon js-button-loader">
									<div></div>
									<div> </div>
									<div></div>
								  </div>
                          		</span>
            </button>
            <button class="btn btn--big" style="height: 54px; width: fit-content; min-width: fit-content;"
                    type="reset" value="Сбросить"
            >
                <span class="btn__label">Сбросить</span>
                <span class="btn__loader-icon" style="font-size: 16px;">
								  <div class="loading-icon js-button-loader">
									<div></div>
									<div> </div>
									<div></div>
								  </div>
                          		</span>
            </button>
        </div>
	</form>
</div>

