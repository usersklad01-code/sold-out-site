<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Предобработка полей
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * @global \CUser $USER
 * ****************************************************************************/
use Bitrix\Main\Localization\Loc;

// Подправлем сообщения об ошибках
unset($arResult["ERRORS"]['LOGIN']);
if (!empty($arResult["ERRORS"])) {
	foreach ($arResult["ERRORS"] as $key => $error) {
		if (intval($key) == 0 && $key !== 0) {
			$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;" . Loc::getMessage("REGISTER_FIELD_" . $key) . "&quot;", $error);
		}
	}
}