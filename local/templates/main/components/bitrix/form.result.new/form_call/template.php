<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Форма обратной связи
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * ****************************************************************************/

echo $arResult["FORM_NOTE"];
if ($arResult["isFormNote"] != "Y") {
	echo $arResult["FORM_HEADER"]; ?>
	<div class="round-form__title"><?= $arResult['arForm']['NAME'] ?></div>
	<div class="round-form__container">
		<div class="round-form__input">
            <div class="input-group" style="margin-right: -30px;">
                <? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) { ?>
					<div class=" <?= $FIELD_SID ?>" data-field-key="<?= $FIELD_SID ?>">
						<label>
							<? $arQuestion["HTML_CODE"] = str_replace('<input ', '<input class="inputtext input-group__input js-input"', $arQuestion["HTML_CODE"]);
                            $arQuestion["HTML_CODE"] = preg_replace('/\s*class="inputtext"\s*/', '', $arQuestion["HTML_CODE"]);
                            $arQuestion["HTML_CODE"] = preg_replace('/placeholder="\+7\(___\)___-____"/', ' placeholder=" +7(___)___-____ " ', $arQuestion["HTML_CODE"]);
                            $arQuestion["HTML_CODE"]  = preg_replace('/type="text"/', 'type="text" ', $arQuestion["HTML_CODE"] );
                            ?>
                            <?= $arQuestion["HTML_CODE"] ?>
							<span class="error11 js-error" style="font-weight: 500;font-size: 14px;line-height: 17px;color: #f54a04;"></span>
						</label>
					</div>
				<? } ?>
			</div>
            <svg class="btn__icon btn__icon--right" width="16" height="11" style="z-index: 1; margin: 14px 13px; pointer-events: none">
                <use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#arrow"></use>
            </svg>
			<input class="btn round-btn footer-form__btn js-form-submit-btn button--primary" <?= (intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : ""); ?>
				   type="submit" style="height:40px;width:40px;min-width:40px;"
				   name="web_form_submit"
				   value=" "/>
		</div>
		<? if ($arResult["isFormErrors"] == "Y"): ?><?= $arResult["FORM_ERRORS_TEXT"]; ?><? endif; ?>
		<span><?= $arResult['arForm']['DESCRIPTION']; ?></span>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {
			$('.inputtext').inputmask("+7(999)999-9999");
		});
	</script>
	<?= $arResult["FORM_FOOTER"] ?>
	<?
}