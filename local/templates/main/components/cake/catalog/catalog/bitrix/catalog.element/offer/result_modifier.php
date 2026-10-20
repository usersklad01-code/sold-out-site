<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** **************************************************************************
 * Предобработка параметров
 * @var array $arParams
 * @var array $arResult
 * ***************************************************************************/
require("lib/helper.php");
$arParams = $this->getComponent()->applyTemplateModifications();

/** *************************************************************************
 * Выбранное sku
 * **************************************************************************/
if (is_array($arResult['OFFERS'])) {
	foreach($arResult['OFFERS'] as $key => $offer) {
		if ($offer['ID'] === $arParams['OFFER_ID']) {
			$arResult['OFFERS_SELECTED'] = $key;
			break;
		}
	}

	if (!isset($arResult['OFFERS_SELECTED'])) {
		$arResult['OFFERS_SELECTED'] = array_keys($arResult['OFFERS'])[0];
	}
}

/** *************************************************************************
 * Свойтсва sku для выбора модели
 * **************************************************************************/

// убираем из списка все свойтсва, которые не участвуют в выборе sku
//foreach ($arResult['SKU_PROPS'] as $code => $prop) {
	//    if ($arResult['OFFERS_PROP'][$code] !== true) {
		//        unset($arResult['SKU_PROPS'][$code]);
		//    }
	//}

// если ствойств не осталось, а выбор должен быть - добавлем псевдосвойстов - модель
if (empty($arResult['SKU_PROPS']) && is_array($arResult['OFFERS']) && count($arResult['OFFERS']) > 1) {
    // создаем псевдо-свойство SKU_ID
    $arResult['SKU_PROPS'] = array(
        array(
            "ID" => 0,
            "CODE" => "SKU_ID",
            "NAME" => "Модель",
            "SHOW_MODE" => "S",
            "VALUES" => [],
            "VALUE_COUNT" => count($arResult["OFFERS"])
        )
    );

    // добавляем все товары как вариант исполнения (SKU_ID)
    foreach ($arResult["OFFERS"] as $offer) {
        $arResult['SKU_PROPS'][0]["VALUES"][] = array(
            "ID" => $offer["ID"],
            "NAME" => $offer["NAME"]
        );
    }

    // в каждом торговом предложении ставим новой свойство как парамтер для выбора
    foreach ($arResult["OFFERS"] as &$offer) {
        $offer["TREE"]["PROP_0"] = $offer["ID"];
    }
    unset($offer);
}


/** *************************************************************************
 * Доставка и время работы магазина
 * **************************************************************************/
$arResult['DELIVERY_BLOCK'] = \Cake\Company\Contacts::getDeliveryList();
$arResult['DELIVERY_BLOCK']['365'] = array(
    'NAME' => '1 год',
    'DESCRIBE' => 'гарантийного обслуживания',
    'DESCRIBE_FULL' => 'гарантийного обслуживания'
);


/** **************************************************************************
 * Отзывы и вопросы пользователей
 * ***************************************************************************/

// отзывы
$dbRes = \Cake\Review\ReviewTable::query()
    ->setSelect(['ID', 'AUTHOR', 'TEXT', 'RATING', 'DATE_CREATE'])
    ->where('PRODUCT_ID', '=', $arResult['ID'])
    ->where('ACTIVE', '=', true)
    ->setOrder(['SORT' => 'ASC', 'DATE_CREATE' => 'DESC'])
    ->exec();

$sum = 0;
$arResult["REVIEWS"] = [];
$arResult["REVIEWS_STAT"] = [];
while ($item = $dbRes->fetch()) {
    $arResult["REVIEWS"][] = $item;
	$arResult["REVIEWS_STAT"][$item['RATING']]++;
	$sum += $item['RATING'];
}

// статистика по звездам
if (count($arResult["REVIEWS"]) > 0) {
	$arResult["REVIEWS_AVG"] = round($sum / count($arResult["REVIEWS"]), 1);
	$arResult["REVIEWS_LIKE"] = round(($arResult["REVIEWS_STAT"][5] + $arResult["REVIEWS_STAT"][4]) / count($arResult["REVIEWS"]) * 100);
}

// вопросы и ответы
$dbRes = \Cake\Review\QuestionTable::query()
    ->setSelect(['ID', 'AUTHOR', 'QUESTION', 'ANSWER', 'DATE_CREATE'])
    ->where('PRODUCT_ID', '=', $arResult['ID'])
    ->where('ACTIVE', '=', true)
    ->setOrder(['SORT' => 'ASC', 'DATE_CREATE' => 'DESC'])
    ->exec();

$arResult["QUESTIONS"] = [];
while ($item = $dbRes->fetch()) {
    $arResult["QUESTIONS"][] = $item;
}

// обновляем свойства в товаре, если они не совпадают
$arUpdateProps = [];
if($arResult['PROPERTIES']['RATING_AVG']['VALUE'] != $arResult["REVIEWS_AVG"]) {
	$arResult['PROPERTIES']['RATING_CNT']['VALUE'] = $arResult["REVIEWS_AVG"];
	$arUpdateProps['RATING_AVG'] = $arResult["REVIEWS_AVG"];
}
if ($arResult['PROPERTIES']['RATING_CNT']['VALUE'] != count($arResult["REVIEWS"])) {
	$arResult['PROPERTIES']['RATING_CNT']['VALUE'] = count($arResult["REVIEWS"]);
	$arUpdateProps['RATING_CNT'] = count($arResult["REVIEWS"]);
}
if ($arResult['PROPERTIES']['QUESTIONS_CNT']['VALUE'] != count($arResult["QUESTIONS"])) {
	$arResult['PROPERTIES']['QUESTIONS_CNT']['VALUE'] = count($arResult["QUESTIONS"]);
	$arUpdateProps['QUESTIONS_CNT'] = count($arResult["QUESTIONS"]);
}
if (count($arUpdateProps) > 0) {
	\CIBlockElement::SetPropertyValuesEx($arResult['ID'], $arResult['IBLOCK_ID'], $arUpdateProps);
}