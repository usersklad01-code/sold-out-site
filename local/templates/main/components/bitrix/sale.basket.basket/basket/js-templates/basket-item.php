<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */

$usePriceInAdditionalColumn = in_array('PRICE', $arParams['COLUMNS_LIST']) && $arParams['PRICE_DISPLAY_MODE'] === 'Y';
$useSumColumn = in_array('SUM', $arParams['COLUMNS_LIST']);
$useActionColumn = in_array('DELETE', $arParams['COLUMNS_LIST']);

$restoreColSpan = 2 + $usePriceInAdditionalColumn + $useSumColumn + $useActionColumn;

$positionClassMap = array(
    'left' => 'basket-item-label-left',
    'center' => 'basket-item-label-center',
    'right' => 'basket-item-label-right',
    'bottom' => 'basket-item-label-bottom',
    'middle' => 'basket-item-label-middle',
    'top' => 'basket-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION'])) {
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos) {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION'])) {
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos) {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' ' . $positionClassMap[$pos] : '';
    }
}
?>
<script id="basket-item-template" type="text/html">
    <div class="order-cart order-cart--basket"
         id="basket-item-{{ID}}" data-entity="basket-item" data-id="{{ID}}">
        <div class="order-cart__img">
            <img class="basket-item-image" alt="{{NAME}}"
                 src="{{{IMAGE_URL}}}{{^IMAGE_URL}}/local/templates/main/tpl/assets/img/no-photo.svg{{/IMAGE_URL}}">
        </div>
        <div class="order-cart__content">
            <h3 class="order-cart__title">
                {{#DETAIL_PAGE_URL}}
					<a href="{{DETAIL_PAGE_URL}}">
						{{/DETAIL_PAGE_URL}}
						{{NAME}}
						{{#DETAIL_PAGE_URL}}
					</a>
                {{/DETAIL_PAGE_URL}}
				{{#PROPS_TEXT}}
					<p class="order-cart__props">{{{PROPS_TEXT}}}</p>
				{{/PROPS_TEXT}}
            </h3>
            <p class="order-cart__price" id="basket-item-price-{{ID}}">
                {{{PRICE_FORMATED}}}
            </p>
            <div class="counter-btn" data-entity="basket-item-quantity-block">
                <button type="button" data-entity="basket-item-quantity-minus">
                    <svg width="18" height="18" stroke="#000000">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#minus"></use>
                    </svg>
                </button>
                <span>
                    <input type="text" value="{{QUANTITY}}"
                           {{#NOT_AVAILABLE}} disabled="disabled" {{/NOT_AVAILABLE}}
							data-value="{{QUANTITY}}" data-entity="basket-item-quantity-field"
							id="basket-item-quantity-{{ID}}">
                </span>
                <button type="button" data-entity="basket-item-quantity-plus">
                    <svg width="18" height="18" stroke="#000000">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#plus"></use>
                    </svg>
                </button>
            </div>
        </div>
        <div class="order-cart__btns">
            <button class="busket-btn" type="button" data-entity="basket-item-delete">
                <svg width="24" height="24" stroke="#000000">
                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#trash-icon"></use>
                </svg>
            </button>
        </div>
    </div>
</script>