<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Форма подтверждения sms
 * @var array $arParams
 * @var array $arResult
  * ****************************************************************************/ ?>
<form class="modal-registration__form" method="post" action="/personal/auth/register.php" name="regform" enctype="multipart/form-data">
	<?php

	// Скрытые поля
	if ($arResult["BACKURL"] <> '') { ?>
		<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
	<? } ?>
	<input type="hidden" name="SIGNED_DATA" value="<?=htmlspecialcharsbx($arResult["SIGNED_DATA"])?>" />
	<?php

	// SMS ?>
	<fieldset>
		<div class="input-group">
			<input type="text" name="SMS_CODE" maxlength="10" placeholder="Код из СМС" class="input-group__input js-input casual-input" value="<?= htmlspecialcharsbx($arResult["SMS_CODE"]) ?>" />
		</div>
		<div id="bx_register_error" style="display:none;"><? ShowError("error") ?></div>
		<div id="bx_register_resend"></div>
	</fieldset>
	<?php

	// Кнопка отправки формы ?>
	<div class="input-group">
		<input type="hidden" name="code_submit_button" value="y" />
		<button class="btn btn--big js-btn-submit" type="submit">
			<span class="btn__label">Проверить код</span>
		</button>
	</div>
</form>
<?php

// Скрипты ?>
<script>
	new BX.PhoneAuth({
		containerId: 'bx_register_resend',
		errorContainerId: 'bx_register_error',
		interval: <?= $arResult["PHONE_CODE_RESEND_INTERVAL"] ?>,
		data: <?= CUtil::PhpToJSObject([
			'signedData' => $arResult["SIGNED_DATA"],
		])?>,
		onError: function (response) {
			var errorDiv = BX('bx_register_error');
			var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
			errorNode.innerHTML = '';
			for (var i = 0; i < response.errors.length; i++) {
				errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
			}
			errorDiv.style.display = '';
		}
	});
</script>