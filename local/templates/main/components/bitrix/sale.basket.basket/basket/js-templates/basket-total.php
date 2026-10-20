<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
        <div class="order-total__res" data-entity="basket-checkout-aligner">
            {{#DISCOUNT_PRICE_FORMATED}}
            <div class="basket-coupon-block-total-price-old">
                {{{PRICE_WITHOUT_DISCOUNT_FORMATED}}}
            </div>
            {{/DISCOUNT_PRICE_FORMATED}}
            <p class="order__total">Итого <span data-entity="basket-total-price"> {{{PRICE_FORMATED}}}</span></p>


            <div class="order-total-btns">
                <button class="btn btn--big" style="height:54px;width:fit-content;min-width:fit-content;" height="54px" type="button" data-entity="basket-checkout-button" onclick="ym(53942923,'reachGoal','oformit')">
                    <span class="btn__label">Оформить</span>
                </button>
				<a href="/catalog/" class="btn btn--big-main" style="height:54px;width:100%;min-width:fit-content;" height="54px" type="button">
					<span class="btn__label">Вернуться в каталог</span>
				</a>
            </div>
        </div>

        <div class="installment order__installment">
            <div class="installment__text">
                <p>В рассрочку <br> от 3000 ₽</p>
                <img src="<?=SITE_TEMPLATE_PATH?>/tpl/assets/img/installment.png" alt="">
            </div>
            <a class="btn btn--big btn--gray" style="height:36px;width:fit-content;min-width:fit-content;" href="/info/credit_page/">
                <span class="btn__label">Подробнее</span>
            </a>
        </div>
</script>