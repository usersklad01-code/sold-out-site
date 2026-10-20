<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.line",
	"json",
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"PATH_TO_BASKET" => SITE_DIR . "personal/cart/",
		"PATH_TO_ORDER" => SITE_DIR . "personal/order/make/",
		"SHOW_NUM_PRODUCTS" => "Y",
		"SHOW_TOTAL_PRICE" => "Y",
		"SHOW_EMPTY_VALUES" => "Y",
		"SHOW_PERSONAL_LINK" => "Y",
		"PATH_TO_PERSONAL" => SITE_DIR . "personal/",
		"SHOW_AUTHOR" => "Y",
		"PATH_TO_AUTHORIZE" => "",
		"SHOW_REGISTRATION" => "Y",
		"PATH_TO_REGISTER" => SITE_DIR . "login/",
		"PATH_TO_PROFILE" => SITE_DIR . "personal/",
		"SHOW_PRODUCTS" => "Y",
		"SHOW_DELAY" => "N",
		"SHOW_NOTAVAIL" => "N",
		"SHOW_IMAGE" => "Y",
		"SHOW_PRICE" => "Y",
		"SHOW_SUMMARY" => "Y",
		"POSITION_FIXED" => "N",
		"MAX_IMAGE_SIZE" => "70",
		"HIDE_ON_BASKET_PAGES" => "Y"
	)
);
