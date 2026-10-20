<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

foreach($arResult["MESSAGE"] as $itemID=>$itemValue)
	echo ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"OK"));
foreach($arResult["ERROR"] as $itemID=>$itemValue)
	echo ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"ERROR"));

?>


    <?
	//show confirmation form
	if($arResult["ID"]>0 && $arResult["SUBSCRIPTION"]["CONFIRMED"] <> "Y")
	{
		include("confirmation.php");
	}

    //setting section
	include("setting.php");

	if($arResult["ID"]>0) {
		include("status.php");
	}
	?>