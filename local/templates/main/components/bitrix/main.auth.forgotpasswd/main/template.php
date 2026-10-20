<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** ***************************************************************************
 * Форма восстановления пароля
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * @global \CUser $USER
 * ****************************************************************************/

// Если уже авторизован, переходим на главную
if ($arResult['AUTHORIZED']) { ?>
	<div>
		<p>Подождите, идет проверка...</p>
		<script>document.location.href = '/';</script>
	</div>
	<? return;
}

// Форма регистрации ?>
<div class="modal-registration">
	<form class="modal-registration__form" method="post" action="/personal/auth/forgot.php" name="regform" enctype="multipart/form-data">
		<?php

		// Сообщения об ошибках
		if (!empty($arResult["ERRORS"])) {
			ShowError(implode("<br />", $arResult["ERRORS"]));
		} elseif (!empty($arResult['SUCCESS'])) { ?>
			<div class="alert alert-success">
				<?= $arResult['SUCCESS'] ?>
			</div>
			<? echo '</form></div>';
			return;
		}

		// Информационная подсказка ?>
		<fieldset>
			<div class="input-group">
				Если вы забыли пароль, введите e-mail. <br/>
				Контрольная строка для смены пароля	будет высланы вам по e-mail.
			</div>
		</fieldset>
		<?php

		// Поле для ввода email ?>
		<fieldset>
            <div class="error">Поле не заполнено</div>
			<div class="input-group">
				<input type="email" name="<?= $arResult['FIELDS']['email'] ?>" maxlength="255" placeholder="E-mail" class="send-forgot-form input-group__input js-input casual-input" />
			</div>
		</fieldset>
		<?php

		// Кэпча
		if ($arResult['CAPTCHA_CODE']) { ?>
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

		// Ссылка на авторизацию и регистрацию ?>
        <div class="input-group">
			<a href="/personal/auth/" class="modal-enter__form-reg js-url-auth">Авторизация</a>
			<a href="/personal/auth/register.php" class="modal-enter__form-reg js-url-register">Регистрация</a>
        </div>
		<?

		// Кнопка отправки формы ?>
		<div class="input-group">
			<input type="hidden" name="<?= $arResult['FIELDS']['action'] ?>" value="y" />
			<button class="btn btn--big js-btn-submit" disabled type="submit">
				<span class="btn__label">Отправить</span>
			</button>
		</div>
	</form>
</div>
<script>
    $('.send-forgot-form').on('input', function() {
        var email = $(this).val().trim();
        var re = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        var $error = $('.error');
        var $submitButton = $('.js-btn-submit');

        if (email === '') {
            $error.text('Поле не заполнено');
            $submitButton.attr('disabled', true);
        } else if (!re.test(email)) {
            $error.text('Некорректный email');
            $submitButton.attr('disabled', true);
        } else {
            $error.text('');
            $submitButton.attr('disabled', false);
        }
    });

</script>