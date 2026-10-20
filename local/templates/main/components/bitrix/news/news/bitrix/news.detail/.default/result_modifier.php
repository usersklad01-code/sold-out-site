<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$resNews = CIBlockElement::GetList(
    ['ACTIVE_FROM' => 'DESC'],
    [
        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
        "ACTIVE" => "Y",
        "!ID" => $arResult["ID"]
    ],
    false,
    ['nTopCount' => 4],
    [
        "ID",
        "IBLOCK_ID",
        "NAME",
        "DATE_ACTIVE_FROM",
        "DETAIL_PAGE_URL",
        "ACTIVE_FROM"
    ]
);
while ($ob = $resNews->GetNextElement()) {
    $arFields = $ob->GetFields();
    $arResult["SOME_NEWS"][$arFields["ID"]] = $arFields;
}

$resBanner = CIBlockElement::GetList([],
    [
        "IBLOCK_ID" => IB_BANNERS,
        "ACTIVE" => "Y",
        "!" . $arParams['BANNER_PROP_CODE'] => false
    ],
    false,
    ['nTopCount' => 1],
    [
        "ID",
        "IBLOCK_ID",
        "NAME",
        "PREVIEW_PICTURE",
        "PROPERTY_BTN_NAME",
        "PROPERTY_LINK",
        "PROPERTY_DESC",
        "PROPERTY_SHOW_NEWS",
        "PROPERTY_SHOW_ARTICLES"
    ]
);
while ($ob = $resBanner->GetNextElement()) {
    $arFields = $ob->GetFields();
    if ($arFields["PREVIEW_PICTURE"] > 0) {
        $arFields["PREVIEW_PICTURE"] = CFile::GetFileArray($arFields["PREVIEW_PICTURE"]);
    }

    $arResult["BANNER"] = $arFields;
}