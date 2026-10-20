<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** *************************************************************************
 * Блок с рекомендациями BigData
 * @var array $arParams
 * @global \CMain $APPLICATION
 * **************************************************************************/

// параметры BigData
$paramsBigData = array(
	'uid' => ($_COOKIE['BX_USER_ID'] ?: $_SESSION["fixed_session_id"]),
	'aid' => \Bitrix\Main\Analytics\Counter::getAccountId(),
	'ib' => IB_CATALOG,
	'count' => 20,
);

// Возможные типы рекомендаций (берем случайную)
$possibleTypes = array('similar', 'personal');
$type = $possibleTypes[array_rand($possibleTypes)];

switch ($type) {
	case 'personal':
		$paramsBigData['op'] = 'recommend';
		break;
	case 'similar':
		if ($arParams['ITEM_ID'] > 0) {
			$paramsBigData['op'] = 'simitems';
			$paramsBigData['eid'] = $arParams['ITEM_ID'];
		} else {
			$paramsBigData['op'] = 'recommend';
		}
		break;
	default:
		$paramsBigData['op'] = 'recommend';
}

// Контейнер для слайдера ?>
<div id="slider-bigdata-container"></div>
<?php

// Скрипты ?>
<script src="<?= SITE_TEMPLATE_PATH ?>/include_areas/catalog/slider-bigdata/script.js"></script>
<script>
	new DJSliderBigData(<?= \Bitrix\Main\Web\Json::encode(array(
		'bigdata' => array(
			'url' => 'https://analytics.bitrix.info/crecoms/v1_0/recoms.php',
			'params' => $paramsBigData
		),
		'ajax' => '/local/templates/main/include_areas/catalog/slider-bigdata/ajax.php',
		'idContainer' => 'slider-bigdata-container'
	)) ?>);
</script>
