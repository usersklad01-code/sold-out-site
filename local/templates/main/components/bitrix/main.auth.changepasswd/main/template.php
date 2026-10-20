<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** ***************************************************************************
 * Форма восстановления пароля
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * @global \CUser $USER
 * ****************************************************************************/

// Для авторизованных - ничего не выводим
if ($arResult['AUTHORIZED']) {
	echo 'Вы зарегистрированы и успешно авторизовались.';
	return;
}

$fields = $arResult['FIELDS'];
?>
<div class="modal-registration">
	<form class="modal-registration__form" method="post" action="/personal/auth/change-password.php" name="regform" enctype="multipart/form-data">
		<?php

		// Сообщения об ошибках
		if (!empty($arResult["ERRORS"])) {
			ShowError(implode("<br />", $arResult["ERRORS"]));
		}  elseif ($arResult['SUCCESS']) { ?>
			<div class="alert alert-success">
				<?= $arResult['SUCCESS'] ?>
			</div>
		<? }

		// Поле ввода ?>
		<fieldset>
			<div class="input-group">
				<input type="text" name="<?= $arResult['FIELDS']['login'] ?>" value="<?= \htmlspecialcharsbx($arResult['LAST_LOGIN']) ?>" placeholder="Логин" maxlength="255" class="input-group__input js-input casual-input"/>
			</div>
			<div class="input-group">
				<input type="text" name="<?= $arResult['FIELDS']['checkword'] ?>" value="<?= \htmlspecialcharsbx($arResult[$arResult['FIELDS']['checkword']]) ?>" placeholder="Контрольная строка" maxlength="255" class="input-group__input js-input casual-input"/>
			</div>
			<div class="input-group">
				<input type="text" name="<?= $arResult['FIELDS']['password'] ?>" value="" placeholder="Пароль" maxlength="255" class="input-group__input js-input casual-input"/>
			</div>
			<div class="input-group">
				<input type="text" name="<?= $arResult['FIELDS']['confirm_password'] ?>" value="" placeholder="Подтверждение пароля" maxlength="255" class="input-group__input js-input casual-input"/>
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

		// Кнопка отправки формы ?>
		<div class="input-group">
			<input type="hidden" name="<?= $arResult['FIELDS']['action'] ?>" value="y" />
			<button class="btn btn--big js-btn-submit" type="submit">
				<span class="btn__label">Отправить</span>
			</button>
		</div>
	</form>
</div>