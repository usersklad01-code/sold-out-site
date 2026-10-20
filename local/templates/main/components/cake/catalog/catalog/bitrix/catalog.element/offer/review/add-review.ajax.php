<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// Входные параметры
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$params = array(
	'AuthorName' => htmlspecialcharsEx($request->get('fio')),
	'AuthorEmail' => htmlspecialcharsEx($request->get('email')),
	'ReviewText' => htmlspecialcharsEx($request->get('text')),
	'Rate' => intval($request->get('rating')) ?: 5,
	'Date' => date('Y-m-dTH:i:s'),
	'ProductId' => intval($request->get('product')),
	'ProductName' => '',
	'ProductURL' => ''
);

// Проверка сессии
$errors = [];
if (!check_bitrix_sessid()) {
    session_regenerate_id(true);
    bitrix_sessid_post();
    $errors['total'] = 'Ваша страница устарела. Обновите страницу и попробуйте отослать вопрос заново.';
}

// Продукт
\Bitrix\Main\Loader::includeModule('iblock');
$product = \CIBlockElement::GetList(
	[],
	['IBLOCK_ID' => IB_CATALOG, 'ID' => $params['ProductId' ?: -1]],
	false.
	false,
	['ID', 'NAME', 'DETAIL_PAGE_URL']
)->GetNext();
if (!$product) {
	$errors['total'] = 'Неизвестная ошибка [1]';
} else {
	$params['ProductName'] = $product['NAME'];
	$params['ProductURL'] = 'https://' . $_SERVER['SERVER_NAME'] . $product['DETAIL_PAGE_URL'];
}

// Проверяем заполненность полей
if (empty($params['AuthorName'])) {
	$errors['fio'] = 'Поле ФИО обязательно для заполнения';
}

if (empty($params['AuthorEmail'])) {
	$errors['email'] = 'Поле c электронной почтой обязательно для заполнения';
}
elseif (!filter_var($params['AuthorEmail'], FILTER_VALIDATE_EMAIL)) {
$errors['email'] = 'Некорректный формат электронной почты';
}

if (empty($params['ReviewText'])) {
	$errors['text'] = 'Поле отзыва обязательно для заполнения';
}


if (count($errors) > 0) {
	echo \Bitrix\Main\Web\Json::encode(array(
		'success' => false,
		'errors' => $errors,
	));
	die;
}

// Сохраняем отзыв и оценку
$api = new \Cake\Review\MneniyaProApi();

/*
use Bitrix\Highloadblock\HighloadBlockTable;
\Bitrix\Main\Loader::includeModule("highloadblock");

$hlbl = 7; // Указываем ID нашего highloadblock блока к которому будет делать запросы.
$hlblock = HighloadBlockTable::getById($hlbl)->fetch(); 

$entity = HighloadBlockTable::compileEntity($hlblock); 
$entity_data_class = $entity->getDataClass(); 

   // Массив полей для добавления
   $data = array(
      "UF_TYPE"=>'',
      "UF_RATING"=>$params['Rate'],
      "UF_PRODUCT_ID"=>$params['ProductId'],
      "UF_TEXT"=>$params['ReviewText'],
      "UF_AUTHOR"=>$params['AuthorName'],
      "UF_DATE_CREATE"=>$params['Date']
   );

   $res = $entity_data_class::add($data);
  $ID = $res->getID();
*/
$res = $api->addReview($params);

// обнуляем дату последней синхронизации отзывов
\CIBlockElement::SetPropertyValuesEx($product['ID'], IB_CATALOG, array('REVIEW_LAST_UPDATE' => 0));

// Результат
if ($res) {
	echo \Bitrix\Main\Web\Json::encode(array(
		'success' => true,
		'message' => 'Спасибо за ваш отзыв. После модерации он появится на сайте.',
		'res'=>$res,
		'data' => $data
	));
} else {
	echo \Bitrix\Main\Web\Json::encode(array(
		'success' => true,
		'message' => 'По неизвестной причине отзыв не был сохранен. Попробуйте его оставить позже.',
		'params' => $params
	));
}
