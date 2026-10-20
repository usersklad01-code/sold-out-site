<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Форма регистрации
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * @global \CUser $USER
 * ****************************************************************************/

// Если уже авторизован, переходим на главную
if ($USER->IsAuthorized()) { ?>
	<div>
		<p>Подождите, идет проверка...</p>
		<script>
            ym(53942923,'reachGoal','register_success')
            document.location.href = '/';
        </script>
	</div>
	<? return;
}

// Форма регистрации ?>
<div class="modal-registration">
	<?php

	// Сообщения об ошибках
	if (!empty($arResult["ERRORS"])) {
		ShowError(implode("<br />", $arResult["ERRORS"]));
	}

	// Сама форма
	if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" ) {
		include('form/email-confirm.php');
	} elseif($arResult["SHOW_SMS_FIELD"] == true) {
		include('form/sms-confirm.php');
	} else {
		include('form/register.php');
	} ?>
</div>