<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** *************************************************************************
 * Иконка избранного в шапке
 * @global \CMain $APPLICATION
 * **************************************************************************/

// иконка
$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"PATH" => SITE_TEMPLATE_PATH . "/include_areas/header/favorites/icon.php",
	'CSS' => 'header-top-menu__favorites-btn header-icon-btn'
));

// Подключаем скрипты
$oFav = \Cake\Services\Favorites::getInstance();
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/include_areas/header/favorites/script.js'); ?>
<script>
	$(document).ready(function() {
		new DJ.Favorites(<?= \Bitrix\Main\Web\Json::encode(array(
			'ids' => $oFav->getList()
		)) ?>);
	});
</script>