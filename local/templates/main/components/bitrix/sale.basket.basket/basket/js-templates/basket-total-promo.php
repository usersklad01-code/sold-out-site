<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-promo-template" type="text/html">
        <div class="order-total__res" data-entity="basket-checkout-aligner">
            <?
            if ($arParams['HIDE_COUPON'] !== 'Y') { ?>
                {{#COUPON_LIST}}
                <div>
                        <span>
							<strong>{{COUPON}}</strong> - <?=Loc::getMessage('SBB_COUPON')?> {{JS_CHECK_CODE}}
							{{#DISCOUNT_NAME}}({{DISCOUNT_NAME}}){{/DISCOUNT_NAME}}
						</span>
                    <a class=" btn close-link link" data-entity="basket-coupon-delete" data-coupon="{{COUPON}}" style="cursor: pointer;">
							<?=Loc::getMessage('SBB_DELETE')?>
						</a>
                </div>
                {{/COUPON_LIST}}
            <? } ?>
        </div>
</script>