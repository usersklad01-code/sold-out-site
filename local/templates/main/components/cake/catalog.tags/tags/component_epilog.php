<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $templateData
 * @var string $templateFolder
 * @var CatalogSectionComponent $component
 */

global $APPLICATION;
$current = [];
foreach ($arResult['ITEMS'] as $item){
   $info =  $item->getInfo();
    if (str_contains($_SERVER['SCRIPT_URL'],$info['URL'])){
        $current = $info;
    }
}

if (!empty($current)){
    $APPLICATION->SetPageProperty("seotext", $current['SEO_TEXT']);
}