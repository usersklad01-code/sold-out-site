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
		'message' => 'Не задан товар для сравнения'
	));
	die;
}

// добавляем товар в сравнение
$oCompare = \Cake\Services\Compare::getInstance();
$oCompare->toggle($id);

// результат
echo \Bitrix\Main\Web\Json::encode(array(
	'success' => true,
	'ids' => $oCompare->getList()
));
