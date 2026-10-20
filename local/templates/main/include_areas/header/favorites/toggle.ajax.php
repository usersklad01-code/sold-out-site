<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
/** **************************************************************************
 * Добавление товара в список сравнения
 * ***************************************************************************/

// проверям параметры
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$id = intval($request->get('id'));
if ($id <= 0) {
	echo \Bitrix\Main\Web\Json::encode(array(
		'success' => false,
		'message' => 'Не задан товар для избранного'
	));
	die;
}

// добавляем товар в сравнение
$oFav = \Cake\Services\Favorites::getInstance();
$oFav->toggle($id);

// результат
echo \Bitrix\Main\Web\Json::encode(array(
	'success' => true,
	'ids' => $oFav->getList()
));
