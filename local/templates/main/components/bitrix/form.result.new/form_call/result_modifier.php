<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

global $USER;
$arUser = [];
if ($USER->IsAuthorized()) {
	$rsUser = CUser::GetByID($USER->GetID());
	$arUser = $rsUser->Fetch();
}
$arResult["FORM_HEADER"] = str_replace('method="POST"','method="POST" class="js-form round-form footer__round-form" ', $arResult["FORM_HEADER"]);

foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
	if(count($arQuestion['STRUCTURE']) == 1){
		if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == "text" ||
			$arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == "email"){
			$elem = explode("<br />", $arQuestion["HTML_CODE"],2)[1];
            if($arResult["QUESTIONS"][$FIELD_SID]["CAPTION"]=='Телефон'||$arResult["QUESTIONS"][$FIELD_SID]["CAPTION"]=='Phone')
            {
                $arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"] = str_replace('<input ', '<input placeholder="+7(___)___-____"', $arQuestion["HTML_CODE"]);
            }
        }
	}
}

if ($arParams['ALTER_NAME']){
    $arResult['arForm']['NAME'] = $arParams['ALTER_NAME'];
}