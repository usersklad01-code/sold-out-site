<?php  if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main, Bitrix\Main\Localization\Loc, Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);

if (!empty($arResult['ERRORS']['FATAL'])) {
	foreach ($arResult['ERRORS']['FATAL'] as $error) {
		ShowError($error);
	}

	$component = $this->__component;

	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])) {
		$APPLICATION->AuthForm('', false, false, 'N', false);
	}
} else {
	if (!empty($arResult['ERRORS']['NONFATAL'])) {
		foreach ($arResult['ERRORS']['NONFATAL'] as $error) {
			ShowError($error);
		}
	}?>

	<?if(!empty($arResult['ORDERS'])):?>
		<div class="order-table" role="table">
			<div class="order-table__row order-table__row--head" role="row">
				<div class="order-table__cell" role="cell">№</div>
				<div class="order-table__cell" role="cell">Заказ</div>
				<div class="order-table__cell" role="cell">Дата</div>
				<div class="order-table__cell" role="cell">Статус</div>
			</div>

			<?foreach ($arResult['ORDERS'] as $key => $order){
                    $statusClass = '';
                switch ($order['ORDER']['STATUS_ID']) {
                    case 'F' :
                        $statusClass = 'is-ready';
                        break;
                    case 'CE' :
                        $statusClass = 'is-canceled';
                        break;
                    default :
                        $statusClass = 's-process';
                        break;
                }
                ?>
				<div class="order-table__row <?=$statusClass?>" role="row">
					<div class="order-table__cell" role="cell">
						<span class="order-table__cell-head">№</span>
						<span><?=$order['ORDER']['ID']?></span>
					</div>
					<div class="order-table__cell" role="cell">
						<span class="order-table__cell-head">Заказ</span>
						<?foreach($order['BASKET_ITEMS'] as $item){?>
							<span><a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?=trim($item['NAME'])?></a></span>
						<?}?>
					</div>
					<div class="order-table__cell" role="cell">
						<span class="order-table__cell-head">Дата</span>
						<span><?=$order['ORDER']['DATE_INSERT_FORMATED']?></span>
					</div>
					<div class="order-table__cell" role="cell">
						<span class="order-table__cell-head">Статус</span>
                        <?
                        $status = $arResult['INFO']['STATUS'][$order['ORDER']['STATUS_ID']];
                        ?>
						<span class="order-table__status"><?=$status['NAME']?></span>
						<?if($order['ORDER']['STATUS_ID'] != 'F' && $order['ORDER']['STATUS_ID'] != 'CE'){?>

							<a class="btn btn--light-gray btn--smallest "
                               style="height:54px;width:fit-content;min-width:fit-content;" height="54px" type="button"
                               href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"])?>"
                            >
								<span class="btn__label">Отменить</span>
								<div class="btn__loader-icon" style="font-size: 16px;">
									<div class="loading-icon js-button-loader">
										<div></div>
										<div> </div>
										<div></div>
									</div>
								</div>
							</a>
						<?}?>
					</div>
				</div>
			<?}?>
		</div>

		<?echo $arResult["NAV_STRING"]; ?>
	<?else:?>
		Список заказов пуст :(
	<?endif?>
<?}?>