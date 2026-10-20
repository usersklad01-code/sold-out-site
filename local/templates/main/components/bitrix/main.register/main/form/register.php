<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Исходная форма регистрации
 * @var array $arParams
 * @var array $arResult
 * ****************************************************************************/ ?>
<form class="modal-registration__form" method="post" action="/personal/auth/register.php" name="regform" enctype="multipart/form-data">
	<?php

	// Скрытые поля
	if ($arResult["BACKURL"] <> '') { ?>
		<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
	<? }

	// ФИО ?>
	<fieldset>
		<div class="input-group">
			<input type="text" name="REGISTER[LAST_NAME]" maxlength="50" placeholder="Фамилия" class="input-group__input js-input casual-input" value="<?= $arResult['VALUES']['LAST_NAME'] ?>" />
		</div>
		<div class="input-group">
			<input type="text" name="REGISTER[NAME]" maxlength="50" placeholder="Имя" class="input-group__input js-input casual-input" value="<?= $arResult['VALUES']['NAME'] ?>" />
		</div>
		<div class="input-group">
			<input type="text" name="REGISTER[SECOND_NAME]" maxlength="50" placeholder="Отчество" class="input-group__input js-input casual-input" value="<?= $arResult['VALUES']['SECOND_NAME'] ?>" />
		</div>
	</fieldset>
	<?php

	// Номер телефона и email ?>
	<fieldset>
		<div class="input-group">
			<input type="tel" name="REGISTER[PHONE_NUMBER]" maxlength="50" placeholder="Телефон" class="input-group__input js-input casual-input tel-login" value="<?= $arResult['VALUES']['PHONE_NUMBER'] ?>" />
		</div>
		<div class="input-group">
			<input type="email" name="REGISTER[EMAIL]" maxlength="50" placeholder="Email" class="input-group__input js-input casual-input email-login" value="<?= $arResult['VALUES']['EMAIL'] ?>" />
		</div>
	</fieldset>
	<?php

	// Пароль ?>
	<fieldset>
		<div class="input-group">
			<input type="password" name="REGISTER[PASSWORD]" maxlength="30" placeholder="Пароль" class="input-group__input js-input casual-input" autocomplete="off" />
		</div>
		<div class="input-group">
			<input type="password" name="REGISTER[CONFIRM_PASSWORD]" maxlength="30" placeholder="Подтверждение пароля" class="input-group__input js-input casual-input" autocomplete="off" />
		</div>
	</fieldset>
	<?php

	// Кэпча
	if ($arResult["USE_CAPTCHA"] == "Y") { ?>
		<fieldset>
			<div class="input-group">
				<input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="180" height="40" alt="CAPTCHA"/>
			</div>
			<div class="input-group">
				<span>Введите слово на картинке</span>
				<input type="text" name="captcha_word" maxlength="50" class="input-group__input js-input casual-input" autocomplete="off"/>
			</div>
		</fieldset>
	<? }

	// Ссылка на авторизацию и на восстановление пароля ?>
    <div class="input-group">
		<a href="/personal/auth/" class="modal-enter__form-reg js-url-auth">Авторизация</a>
		<a href="/personal/auth/forgot.php" class="modal-enter__form-reg js-url-forgot">Забыли пароль?</a>
    </div>
	<?

	// Кнопка отправки формы ?>
	<div class="input-group">
		<input type="hidden" name="register_submit_button" value="y" />
		<button class="btn btn--big js-btn-submit" type="submit">
			<span class="btn__label">Подтвердить телефон</span>
		</button>
	</div>
</form>
<script type="text/javascript"><?//используется для автоизации в Шапка->избранное?>
    $(document).ready(function () {
        $('.tel-login').inputmask("+7(999)999-9999");
    });
</script>