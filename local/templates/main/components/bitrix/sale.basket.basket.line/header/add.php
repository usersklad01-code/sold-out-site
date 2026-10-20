<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule('iblock');
\Bitrix\Main\Loader::includeModule('catalog');
\Bitrix\Main\Loader::includeModule('sale');

// покупаемый товар
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$product = \Bitrix\Iblock\ElementTable::query()
	->setSelect(['ID', 'NAME', 'PREVIEW_PICTURE'])
	->where('ID', '=', intval($request['id']))
	->where('ACTIVE', '=', 'Y')
	->exec()
	->fetch();

if (!$product) {
	echo \Bitrix\Main\Web\Json::encode(array(
		'STATUS' => 'ERROR',
		'MESSAGE' => 'Продукт не доступен для покупки'
	));
	die;
}

// количество
$quantity = intval($request['quantity']);
if($quantity < 0) {
	$quantity = 1;
}

// свойства товара в корзине
$props = [];
foreach ($request['prop'] as $code => $prop) {
	$props[] = array(
		'CODE' => $code,
		'NAME' => (isset($prop['name']) ? $prop['name'] : $code),
		'VALUE' => (isset($prop['value']) ? $prop['value'] : $prop),
		'SORT' => 100,
	);
}

// добавляем в корзину со своим обработчиком
$res = \Bitrix\Catalog\Product\Basket::addProduct(array(
	'PRODUCT_ID' => $product['ID'],
	'QUANTITY' => $quantity,
	'PROPS' => $props
));

if (!$res->isSuccess()) {
	echo \Bitrix\Main\Web\Json::encode(array(
		'STATUS' => 'ERROR',
		'MESSAGE' => $res->getErrorMessages(),
	));
	die;
}

// Все хорошо, результат
echo \Bitrix\Main\Web\Json::encode(array(
	'STATUS' => 'OK',
	'MESSAGE' => '',
	'ITEM' => array(
		'ID' => $product['ID'],
		'NAME' => $product['NAME'],
		'IMG' => $product['PREVIEW_PICTURE'] > 0 ? \CFile::ResizeImageGet($product['PREVIEW_PICTURE'], array("width" => 220, "height" => 220))['src'] : SITE_TEMPLATE_PATH . "/tpl/assets/img/no-photo.svg")
	)
);

// эпилог
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");