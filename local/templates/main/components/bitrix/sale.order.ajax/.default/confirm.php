<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y")
{
	$APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
?>
    <style>
        .page-title--1 {
            display: none;
        }
        .order__layout {
            grid-template-columns: unset;
        }
    </style>
<? if (!empty($arResult["ORDER"])): ?>
    <div class="message__container">
        <div class="content-wrap">
            <b><?=Loc::getMessage("SOA_ORDER_COMPLETE")?></b>
            <div class="message__img" style=" display: flex;justify-content: center;margin: 15px;">
                <img src="/local/templates/main/tpl/assets/img/oneclick-submit-form.svg">
            </div>
            <table class="sale_order_full_table">
                <tr>
                    <td>
                        <?=Loc::getMessage("SOA_ORDER_SUC", array(
                            "#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i'),
                            "#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
                        ))?>
                        <p><?=Loc::getMessage('SOA_ORDER_SUC1')?></p>
                    </td>
                </tr>
            </table>

	</div></div>

<? else: ?>

	<b><?=Loc::getMessage("SOA_ERROR_ORDER")?></b>
	<br /><br />

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])])?>
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?>
			</td>
		</tr>
	</table>

<? endif ?>