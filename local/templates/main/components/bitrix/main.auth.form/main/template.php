<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Форма авторизации
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * @global \CUser $USER
 * ****************************************************************************/

// Если уже авторизован, переходим на главную
if ($arResult['AUTHORIZED']) { ?>
	<div>
		<p>Подождите, идет проверка...</p>
		<script>
            ym(53942923,'reachGoal','vhod_success')
		    document.location.href = '/';
        </script>
	</div>
	<? return;
}

// Окно авторизации ?>
<form class="modal-enter__form" name="form_auth" id="form_auth" method="post" target="_top" action="/personal/auth/">
	<?php

	// Сообщения об ошибках
	if ($arResult['ERRORS']) {
		ShowError(implode("<br />", $arResult["ERRORS"]));
	}

	// Скрытые поля ?>
	<input type="hidden" name="<?= $arResult['FIELDS']['action'] ?>" value="auth" />
	<?php

	// Логин/пароль ?>
	<div class="input-group">
		<input class="tel-login input-group__input js-input casual-input" type="text" name="<?= $arResult['FIELDS']['login'] ?>" maxlength="255" placeholder="Номер телефона" value="<?= \htmlspecialcharsbx($arResult['LAST_LOGIN']) ?>"/>
	</div>
	<div class="input-group">
		<input class="input-group__input js-input casual-input" type="password" name="<?= $arResult['FIELDS']['password'] ?>" maxlength="255" placeholder="Пароль" autocomplete="off"/>
	</div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tel-login').inputmask("+7(999)999-9999");
        });
    </script>
    <?

	// Кэпча
	if ($arResult['CAPTCHA_CODE']) { ?>
		<div class="input-group">
			<input type="hidden" name="captcha_sid" value="<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']) ?>"/>
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="180" height="40" alt="CAPTCHA"/>
			<span>Введите слово на картинке</span>
			<input class="bx-auth-input form-control" type="text" name="captcha_word" maxlength="50" value="" size="15" autocomplete="off"/>
		</div>
	<? }

	// Галка "запомнить меня" ?>
	<label for="USER_REMEMBER">
		<input type="checkbox" id="USER_REMEMBER" name="<?= $arResult['FIELDS']['remember'] ?>" value="Y"/>
		<span>Запомнить меня</span>
	</label>
	<?

	// Ссылка на регистрацию и на восстановление пароля ?>
	<div class="input-group">
		<a href="/personal/auth/register.php" class="modal-enter__form-reg js-url-register">Регистрация</a>
		<a href="/personal/auth/forgot.php" class="modal-enter__form-reg js-url-forgot">Забыли пароль?</a>
	</div>
	<?

	// Кнопка входа ?>
	<div class="input-group">
		<button class="btn btn--big js-btn-submit" type="submit">
			<span class="btn__label">Войти</span>
		</button>
	</div>
</form>