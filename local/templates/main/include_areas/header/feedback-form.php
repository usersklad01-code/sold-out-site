<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Форма обратной связи (перезвоните мне)
 * @global $APPLICATION
 * ***************************************************************************/

$APPLICATION->IncludeComponent(
    "bitrix:form.result.new",
    "form_call",
    Array(
        "CACHE_TIME" => "3600",
        "CACHE_TYPE" => "A",
        "CHAIN_ITEM_LINK" => "",
        "CHAIN_ITEM_TEXT" => "",
        "EDIT_URL" => "",
        "IGNORE_CUSTOM_TEMPLATE" => "Y",
        "LIST_URL" => "",
        "SEF_MODE" => "N",
        "SUCCESS_URL" => "",
        "USE_EXTENDED_ERRORS" => "Y",
        "VARIABLE_ALIASES" => Array("RESULT_ID"=>"RESULT_ID","WEB_FORM_ID"=>"WEB_FORM_ID"),
        "WEB_FORM_ID" => 1,
    )
);?>