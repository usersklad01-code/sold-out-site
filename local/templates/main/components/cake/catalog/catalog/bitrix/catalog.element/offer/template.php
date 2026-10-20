<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** **************************************************************************
 * Шаблон карточки товара
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * ***************************************************************************/
$this->setFrameMode(true);

// текущий элемент
$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers) {
	$curItem = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']];
} else {
	$curItem = $arResult;
}


/** **************************************************************************
 * Карточка товара
 * ***************************************************************************/ ?>
<div class="product-page__detail">
	<div class="product-head">

		<div class="product-head--right">

			<?php

			// Слайдеры фотографий товара (для sku - несколько слайдеров)
			$arSliders = [];
			if (!is_array($arResult['OFFERS']) || count($arResult['OFFERS']) === 0) {
				$arSliders[$arResult['ID']] = \DJ\Helpers\CatalogDetail::preparePictureList($arResult);
			} else {
				foreach ($arResult['OFFERS'] as $offer) {
					$arSliders[$offer["ID"]] = \DJ\Helpers\CatalogDetail::preparePictureList($offer);

				}
			}
			foreach ($arSliders as $id => $slider) { ?>
				<div class="product-slider js-product-slider" data-for-sku="<?= $id ?>" <?= ($curItem['ID'] === $id ? '' : 'style="display:none"') ?>>
					<? // левый слайдер с иконками ?>
					<div class="product-left-slider">
						<button class="product-left-slider__prev-btn js-btn-prev" type="button">
							<svg width="27" height="13">
								<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#arrow-big"></use>
							</svg>
						</button>
						<div class="swiper product-left-slider__slider js-left-slider">
							<div class="swiper-wrapper">
								<? foreach ($slider as $photo) { ?>
									<div class="swiper-slide product-left-slider__slide">
										<img src="<?= $photo['SRC'] ?>" alt="img">
									</div>
								<? } ?>
							</div>
						</div>
						<button class="product-left-slider__next-btn js-btn-next" type="button">
							<svg width="27" height="13">
								<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#arrow-big"></use>
							</svg>
						</button>
					</div>
					<? // основной слайдер ?>
					<div class="swiper product-main-slider js-main-slider">
						<div class="swiper-wrapper">
							<? foreach ($slider as $photo) { ?>
								<div class="swiper-slide product-main-slider__slide">
									<img src="<?= $photo['SRC'] ?>" alt="img" />
								</div>
							<? } ?>
						</div>
					</div>
				</div>
			<? } ?>
		</div>
		<div class="product-head__info">
			<div>
				<?php

				// Заголовок (название товара) ?>
				<h1 class="product-head__title page-title page-title--1 js-product-title"><?= $curItem["NAME"] ?></h1>
				<?php

				// Иконки рейтинга и отзывов
				// Рейтинг показываем только при наличии отзывов, иначе — «Отзывов пока нет»
				$ratingCount = (int)($arResult['PROPERTIES']['RATING_CNT']['VALUE'] ?? 0);
				$ratingAvg = $arResult['PROPERTIES']['RATING_AVG']['~VALUE'] ?? 0; ?>
				<div class="product-head__rating">
					<? if ($ratingCount > 0) { ?>
						<? // Иконка рейтинга ?>
						<div class="product-head__stars">
							<svg width="17" height="17"><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#star"></use></svg>
							<span><?= $ratingAvg ?></span>
						</div>
						<? // Иконка комментариев ?>
						<div class="product-head__feedback">
							<svg width="17" height="17"><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#feedback-cloud"></use></svg>
							<span><?= $ratingCount ?></span>
						</div>
					<? } else { ?>
						<div class="product-head__feedback product-head__feedback--empty">
							<svg width="17" height="17"><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#feedback-cloud"></use></svg>
							<span>Отзывов пока нет</span>
						</div>
					<? } ?>
					<? // Служебный артикул (XML_ID из МойСклад) покупателю не показываем ?>
				</div>
			</div>

			<?php

			// Выбор торгового предложения
			if ($haveOffers && !empty($arResult['SKU_PROPS'])) { ?>
				<div class="product-short-character">
					<? foreach ($arResult['SKU_PROPS'] as $skuProp)  { ?>

						<div class="product-short-character__row product-short-character__row--<?= ToLower($skuProp['CODE']) ?> js-sku-prop" data-prop="<?= $skuProp['ID'] ?>">
							<span class="product-short-character__name"><?= $skuProp['NAME'] ?></span>
							<div class="product-short-character__content">
								<? $curPropValue = $curItem['TREE']['PROP_' . $skuProp['ID']];
								foreach ($skuProp['VALUES'] as $value) {?>

								<?	if ($value['ID'] != 0) {
                                    if ($skuProp['CODE'] == 'COLOR') { ?>
                                        <div class="radio-color" title="<?= $value['NAME'] ?>">
                                            <label class="radio-color__label">
                                                <input class="radio-color__input visually-hidden" type="radio" name="PROP_<?= $skuProp['ID'] ?>" value="<?=$value['ID']?>" <?= $curPropValue === $value['ID'] ? "checked" : "" ?> onclick="ym(53942923,'reachGoal','click_color')"/>
                                                <span><span class="radio-color__color" style="background-color: <?= ($value['XML_ID'][0] === '#' ? $value['XML_ID'] : '#'.$value['XML_ID']) ?>"></span></span>
                                            </label>
                                        </div>

                                        <script type="text/javascript">
                                            document.addEventListener("DOMContentLoaded", function(){
                                                var colorButtons = document.querySelectorAll('.radio-color');
                                                <? echo $offers = [1, 2, 3, 4, 5, 6, 7] ?>
                                                    for (i = 0; i < colorButtons.length; i++) {
                                                        colorButtons[i].addEventListener("click", function(){
                                                            var colors = <?php echo json_encode($arResult['OFFERS'][0]['PROPERTIES']['COLOR']['VALUE']) ?>;
                                                            var colorClientEl = this.querySelector('.radio-color__color').getAttribute('style');
                                                            var colorClient = colorClientEl.slice(-6);
                                                                <?php for ($i = 0; $i < count($offers); $i++) { ?>
                                                                        if (<?php echo json_encode($arResult['OFFERS'][$offers[$i]]['PROPERTIES']['COLOR']['VALUE']) ?> === colorClient) {
                                                                            var url = <?php echo json_encode($_SERVER['REQUEST_URI']) ?>;

                                                                            const lastSlashIndex = url.lastIndexOf('/');
                                                                            const secondLastSlashIndex = url.lastIndexOf('/', lastSlashIndex - 1);

                                                                            if (secondLastSlashIndex !== -1) {
                                                                                const trimmedUrl = url.substring(0, secondLastSlashIndex) + "/" + <?php echo json_encode($arResult['OFFERS'][$offers[$i]]['CODE']) ?> + "/";
                                                                                console.log("URL без символьного кода: " + trimmedUrl);
                                                                                history.pushState(null, null, trimmedUrl);
                                                                            } else {
                                                                                console.log("Второй слеш не найден.");
                                                                            }
                                                                            console.log("Цвет из ТП: " + <?php echo json_encode($arResult['OFFERS'][$offers[$i]]['PROPERTIES']['COLOR']['VALUE']) ?> + " совпадает с цветом кружка: " + colorClient);
                                                                            console.log("Нужно подставить этот код: " + <?php echo json_encode($arResult['OFFERS'][$offers[$i]]['CODE']) ?> );
                                                                        }
                                                                <?php } ?>
                                                        })
                                                    }
                                            });
                                        </script>
										<? } else { ?>
											<div class="radio-storage" title="<?= $value['NAME'] ?>">
												<label class="radio-storage__label">
													<input class="radio-storage__input visually-hidden" type="radio" name="PROP_<?= $skuProp['ID'] ?>" value="<?=$value['ID']?>" <?= $curPropValue === $value['ID'] ? "checked" : "" ?> onclick="ym(53942923,'reachGoal','click_memory')"/>
													<span class="radio-storage__storage"><?=$value['NAME']?></span>
												</label>
											</div>
										<? }
									}
								} ?>
							</div>
						</div>
					<? } ?>
				</div>
			<? } ?>

			<div class="product-head__details">
				<div class="product-head__details-col product-head__details-col--left">
					<?php

					// Цена
					$price = $curItem['ITEM_PRICES'][$curItem['ITEM_PRICE_SELECTED']]; ?>
					<div class="product-head__price product-price">
						<div class="product-price__sale" <?= $price['PERCENT'] > 0 ? '' : 'style="display:none"'?>>
							<div class="product-price__sale-value js-product-discount"><?= $price['PRINT_RATIO_BASE_PRICE'] ?></div>
							<div class="product-price__sale-percent js-product-discount-percent">-<?= $price['PERCENT'] ?>%</div>
						</div>
						<div class="product-price__main-value js-product-price"><?= $price['PRINT_RATIO_PRICE'] ?></div>
					</div>
					<?php

					// Наличие ?>
                    <div style="display: flex; gap: 8px;">
                        <div class="product-head__available js-prod-available"><?= $curItem['CAN_BUY'] ? 'В наличии' : 'Не в наличии' ?></div>
                        <div class="js-prod-available-check">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align: middle; margin-bottom: 3px;">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9058 5.09916C12.1311 5.32329 12.132 5.68756 11.9078 5.91279L7.54673 10.2953C7.29648 10.5468 6.88932 10.5464 6.63957 10.2944L7.0482 9.8894L6.63957 10.2944L4.64919 8.28626C4.42551 8.06058 4.42713 7.69631 4.6528 7.47263C4.87848 7.24895 5.24276 7.25057 5.46644 7.47624L7.09432 9.11866L11.0922 5.10115C11.3163 4.87592 11.6806 4.87503 11.9058 5.09916Z" fill="#E84E0F"/>
                                <circle cx="8.27893" cy="7.72107" r="7.22107" stroke="#E84E0F"/>
                            </svg>
                        </div>
                    </div>
					<?php

					// Информация о доставке ?>
					<div class="product-head__delivery">
						<ul class="product-head__delivery-list">
							<? foreach ($arResult['DELIVERY_BLOCK'] as $code => $item) { ?>
								<li class="product-head__delivery-item">
									<svg width="29" height="14"><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#<?= $code ?>"></use></svg>
									<span><b><?= $item['NAME'] ?></b>&nbsp;<span><?= $item['DESCRIBE_FULL'] ?></span></span>
								</li>
							<? } ?>
						</ul>
					</div>
					<?php
                    // Кнопки покупки, сравнения, избранного
                    $can_buy_button_active=$curItem['CAN_BUY'] ? '' : 'disabled'; ?>

					<div class="product-head__btns">
						<div <?=$can_buy_button_active?> class="btn btn--xl btn--big js-btn-buy <?= $curItem['CAN_BUY'] ? '' : 'btn--gray' ?>" data-id="<?=$curItem['ID']?>" onclick="ym(53942923,'reachGoal','dobavlenie_v_korziny')">
							<span class="btn__label"><?= $curItem['CAN_BUY'] ? 'В корзину' : 'Отсутствует' ?></span>
							<svg class="btn__icon btn__icon--right"><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#cart"></use></svg>
							<div class="btn__loader-icon"><div class="loading-icon"><div></div><div> </div><div></div></div></div>
						</div>
						<div <?=$can_buy_button_active?> class="btn btn--xl btn--big js-btn-oneclick <?= $curItem['CAN_BUY'] ? '' : 'btn--gray' ?>"  data-id="<?=$curItem['ID']?>" <?= $curItem['CAN_BUY'] ? '' : 'display:none;' ?> onclick="ym(53942923,'reachGoal','1click')">
							<span class="btn__label"><?= 'Купить в 1 клик' ?></span>
							<div class="btn__loader-icon"><div class="loading-icon"><div></div><div> </div><div></div></div></div>
						</div>
						<div class="btn round-btn-xl round-btn btn--big btn--gray js-btn-favorites" data-id="<?=$curItem['ID']?>">
							<span class="btn__label"></span>
							<svg class="btn__icon btn__icon--right"><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#hart"></use></svg>
							<div class="btn__loader-icon"><div class="loading-icon"><div></div><div> </div><div></div></div></div>
						</div>
						<div class="btn round-btn round-btn-xl btn--big btn--gray js-btn-compare" data-id="<?=$curItem['ID']?>">
							<span class="btn__label"></span>
							<svg class="btn__icon btn__icon--right"><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#compare"></use></svg>
							<div class="btn__loader-icon"><div class="loading-icon"><div></div><div> </div><div></div></div></div>
						</div>
					</div>
				</div>
				<?php

				// Блок "в рассрочку" (по ТЗ - это статика) ?>
				<div class="product-head__details-col product-head__details-col--right">
					<div class="installment product-head__installment">
						<div class="installment__text">
							<p>В рассрочку <br> от 3000 ₽</p>
							<img src="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/img/installment.png" alt="" />
						</div>
						<a class="btn btn--big btn--gray" href="/info/credit_page/">
							<span class="btn__label">Подробнее</span>
						</a>
					</div>
				</div>
			</div>
			<?php

			// Описание
			$dsc = !empty($curItem['~DETAIL_TEXT']) ? $curItem['~DETAIL_TEXT'] : $arResult['~DETAIL_TEXT']; ?>
			<div class="product-description js-product-description short" <?= empty($dsc) ? 'style="display:none"' : '' ?>>
				<div class="product-description__title">Описание</div>
				<div class="product-description__text-container js-txt"><?= $dsc ?></div>
				<button hidden class="product-characteristic__link-button link-button js-btn" type="button" data-title-close="Скрыть описание" data-title-open="Показать все"></button>
			</div>
		</div>
	</div>
	<div class="product-page__row product-page__row--start">
		<?php

		// Характеристики ?>
		<div class="product-characteristic">
			<h2 class="title-3">Характеристики</h2>
			<div class="product-characteristic__list">
				<? // служебные свойства, которые покупателю не показываем
				$hiddenProps = ['Артикул', 'Артикул МойСклад'];

				// характеристики товара (без служебных и дублей)
				$seenProps = [];
				foreach ($arResult['DISPLAY_PROPERTIES'] as $prop) {
					if (in_array($prop['NAME'], $hiddenProps, true) || isset($seenProps[$prop['NAME']])) continue;
					$seenProps[$prop['NAME']] = true; ?>
					<div data-for-sku="0"  class="product-characteristic__item js-property-row">
						<div class="product-characteristic__item-name"><?= $prop['NAME'] ?></div>
						<div class="product-characteristic__item-value"><?= $prop['VALUE'] ?></div>
					</div>
				<? }
				// характеристики всех торговых предложений
				foreach ($arResult['OFFERS'] as $offer) {
					$seenProps = [];
					foreach ($offer['DISPLAY_PROPERTIES'] as $prop) {
						if (in_array($prop['NAME'], $hiddenProps, true) || isset($seenProps[$prop['NAME']])) continue;
						$seenProps[$prop['NAME']] = true; ?>
						<div data-for-sku="<?= $offer['ID'] ?>" class="product-characteristic__item js-property-row" <?= $offer['ID'] !== $curItem['ID'] ? 'style="display:none"' : ''?>>
                            <div class="product-characteristic__item-name"><?= $prop['NAME'] ?></div>
                            <div class="product-characteristic__item-value"><?= $prop['VALUE'] ?></div>
						</div>
					<? }
				} ?>
			</div>
			<button class="product-characteristic__link-button link-button js-property-more" type="button">Показать все характеристики</button>
		</div>
		<?php

		// Отзывы
		include('review/list.php'); ?>
	</div>
</div>
<script>
    document.querySelectorAll('.product-head__rating .product-head__stars, .product-head__feedback')
        .forEach(element => {
            element.addEventListener('click', function() {
                const reviewsSection = document.querySelector('.product-reviews');
                window.scrollTo({
                    top: reviewsSection.getBoundingClientRect().top + window.scrollY - 150,
                    behavior: 'smooth'
                });
            });
        });
</script>
<script>
	//document.querySelectorAll('.radio-color__input').forEach(input => {
	//input.addEventListener("click", function() {
	// const selectedColorId = this.value; // Получаем ID выбранного цвета
	//const productId = <?= $curItem['ID'] ?>; // ID текущего товара
            
            // Находим выбранное торговое предложение
	//const selectedOffer = <?= json_encode($arResult['OFFERS']) ?>.find(offer => offer['TREE']['PROP_<?= $skuProp['ID'] ?>'] == selectedColorId);
	//const offerSymbolCode = selectedOffer ? selectedOffer['CODE'] : ''; // Получаем символьный код выбранного предложения
            
            // Формируем новый URL с символьным кодом
	//const newUrl = `<?= $arResult['DETAIL_PAGE_URL'] ?>?color=${selectedColorId}&product=${productId}&offer=${offerSymbolCode}`;

            // Обновляем URL в браузере без перезагрузки страницы
	//window.history.pushState({path: newUrl}, '', newUrl);
            
            // При необходимости, можно также вызвать дополнительную логику, например, загрузку новых данных о товаре
            // fetchProductData(productId, selectedColorId, offerSymbolCode);
	//});
	//});
</script>

<?php


/** **************************************************************************
 * Подключение скриптов
 * ***************************************************************************/
$jsParams = array(
	'OFFERS' => [],
	'PRODUCT_ID' => $arResult['ID'],
	'CURRENT_ID' => $curItem['ID']
);
foreach ($arResult['OFFERS'] as $offer) {
	$price = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
	$jsParams['OFFERS'][$offer['ID']] = array(
		'ID' => $offer['ID'],
		'NAME' => $offer['NAME'],
		'PICTURE' => $offer['DETAIL_PICTURE']['SRC'],
		'DESCRIPTION' => $offer['~DETAIL_TEXT'] ?: $arResult['~DETAIL_TEXT'],
		'PROPS' => $offer['TREE'],
        'ARTICLE' => $offer['PROPERTIES']['ARTICLE']['VALUE'],
		'PRICE' => array(
			'VALUE' => $price['PRINT_RATIO_PRICE'],
			'DISCOUNT' => $price['PRINT_RATIO_BASE_PRICE'],
			'DISCOUNT_PERCENT' => $price['PERCENT'],
			'CAN_BUY' => $offer['CAN_BUY']
		),
        'XML_ID' => $offer['XML_ID'],
	);
} ?>
<script>
	$(document).ready(function() {
		new DJ.ProductCard(<?= \Bitrix\Main\Web\Json::encode($jsParams) ?>);
	});
</script>
<?php


/** **************************************************************************
 * Микроразметка
 * ***************************************************************************/
$jsonLD = array(
    "@context" => "https://schema.org",
    "@type" => "Product",
    "name" => $curItem['NAME'],
    "image" => $curItem['PREVIEW_PICTURE']['SRC'],
    "offers" => array(
        "@type" => "Offer",
        "priceCurrency" => "RUB",
        "price" => $curItem['ITEM_PRICES'][$curItem['ITEM_PRICE_SELECTED']]['PRICE'],
        "availability" => "https://schema.org/InStock",
    ),

    "url" => $arResult['DETAIL_PAGE_URL'],
);
// рейтинг в микроразметке — только если есть отзывы
if ($ratingCount > 0) {
    $jsonLD["aggregateRating"] = array(
        "@type" => "AggregateRating",
        "ratingValue" => $ratingAvg,
        "reviewCount" => $ratingCount
    );
} ?>
<script type="application/ld+json">
    <?= json_encode($jsonLD, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
<?php

/** **************************************************************************
 * Подборки товаров для каталога
 * ***************************************************************************/

// Аксессуары
$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"PATH" => SITE_TEMPLATE_PATH . "/include_areas/catalog/slider-accessories.php",
	"ITEMS_IDS" => $arResult['PROPERTIES']['ACCESSORIES']['VALUE'],
	"LINK_ITEM" => ['ID' => $curItem['ID'], 'NAME' => $curItem['NAME']]
));

// С этим товаром покупают (BigData)
$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"PATH" => SITE_TEMPLATE_PATH . "/include_areas/catalog/slider-bigdata/include.php",
	"ITEM_ID" => $arResult['ID'],
));

// Новинки
$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
    "AREA_FILE_SHOW" => "file",
    "PATH" => SITE_TEMPLATE_PATH . "/include_areas/catalog/slider.php",
    "SECTION_ID" => $arResult['SECTION']['PATH'][0]['ID'],
	'FILTER' => array(
		'SECTION_ACTIVE' => 'Y',
		'SECTION_GLOBAL_ACTIVE' => 'Y',
		'OFFERS' => array('>PREVIEW_PICTURE' => 0)
	),
	'SORT' => array('ID' => 'DESC'),
	'TITLE' => 'Новинки'
));

// Выбор покупателей
$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"PATH" => SITE_TEMPLATE_PATH . "/include_areas/catalog/slider.php",
	"SECTION_ID" => $arResult['SECTION']['PATH'][0]['ID'],
	'FILTER' => array(
		'SECTION_ACTIVE' => 'Y',
		'SECTION_GLOBAL_ACTIVE' => 'Y',
		'OFFERS' => array('>PREVIEW_PICTURE' => 0)
	),
	'SORT' => array('PROPERTY_RATING_AVG_VALUE' => 'DESC'),
	'TITLE' => 'Выбор покупателей'
));

// Популярные
$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"PATH" => SITE_TEMPLATE_PATH . "/include_areas/catalog/slider.php",
	"SECTION_ID" => $arResult['SECTION']['PATH'][0]['ID'],
	'FILTER' => array(
		'SECTION_ACTIVE' => 'Y',
		'SECTION_GLOBAL_ACTIVE' => 'Y',
		'OFFERS' => array('>PREVIEW_PICTURE' => 0)
	),
	'SORT' => array('SORT' => 'DESC'),
	'TITLE' => 'Популярные'
));
?>