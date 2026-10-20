<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// проверить входные параметры
$errors = [];
$request = \Bitrix\Main\Context::getCurrent()->getRequest();

if (!check_bitrix_sessid()) {
    session_regenerate_id(true);
    bitrix_sessid_post();
	$errors['total'] = 'Ваша страница устарела. Обновите страницу и попробуйте отослать вопрос заново.';
}

$idProduct = intval($request->get('product'));
if ($idProduct <= 0) {
	$errors['total'] = 'Неизвестная ошибка [1]';
}

$author = htmlspecialcharsEx($request->get('fio'));
if (empty($author)) {
	$errors['fio'] = 'Поле ФИО обязательно для заполнения';
}

$question = htmlspecialcharsEx($request->get('question'));
if (empty($question)) {
	$errors['question'] = 'Вы забыли ввести вопрос';
}

if (count($errors) > 0) {
	echo \Bitrix\Main\Web\Json::encode(array(
		'success' => false,
		'errors' => $errors,
	));
	die;
}

// Сохраняем вопрос
$res = \Cake\Review\QuestionTable::add(array(
	'PRODUCT_ID' => $idProduct,
	'USER_ID' => $GLOBALS['USER']->getId(),
	'AUTHOR' => $author,
	'QUESTION' => $question,
	'ACTIVE' => false,
	'DATE_CREATE' => new \Bitrix\Main\Type\DateTime(),
	'SORT' => 500
));

// Результат
echo \Bitrix\Main\Web\Json::encode(array(
	'success' => true,
	'message' => 'Спасибо за ваш вопрос (№' . $res->getId() . '). После обработки нашими менеджерами ответ на него появится на сайте.',
));