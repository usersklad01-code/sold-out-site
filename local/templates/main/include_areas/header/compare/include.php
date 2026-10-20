<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** *************************************************************************
 * Иконка сравнения в шапке
 * @global \CMain $APPLICATION
 * **************************************************************************/

// иконка
$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"PATH" => SITE_TEMPLATE_PATH . "/include_areas/header/compare/icon.php",
	'CSS' => 'header-top-menu__compare-btn header-icon-btn'
));

// Подключаем скрипты
$oCompare = \Cake\Services\Compare::getInstance();
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/include_areas/header/compare/script.js'); ?>
<script>
	$(document).ready(function() {
		new DJ.Compare(<?= \Bitrix\Main\Web\Json::encode(array(
			'ids' => $oCompare->getList()
		)) ?>);
	});
</script>