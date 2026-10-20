<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Выбор местоположения
 * @global $APPLICATION
 * ***************************************************************************/
$city = \Cake\Location\UserLocation::getInstance()->getCurrentCity();

// компонент выбора города
$APPLICATION->IncludeComponent(
	"bitrix:sale.location.selector.search",
	"header",
	array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"ID" => $city['ID'],
		"CODE" => $city['CODE'],
		"FILTER_BY_SITE" => "N",
		"INITIALIZE_BY_GLOBAL_EVENT" => "",
		"INPUT_NAME" => "CURRENT_CITY_ID",
		"JS_CALLBACK" => "selectLocation",
		"JS_CONTROL_GLOBAL_ID" => "this-location-trigger",
		"PROVIDE_LINK_BY" => "id",
		"SHOW_DEFAULT_LOCATIONS" => "N",
		"SUPPRESS_ERRORS" => "N"
	)
);
