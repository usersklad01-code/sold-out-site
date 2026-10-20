<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** **************************************************************************
 * Список отзывов
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * ***************************************************************************/ ?>
<div class="product-reviews js-review-wrapper">
	<div class="product-reviews__left">
		<?php

		// Табы ?>
		<div class="product-reviews__titles">
			<button class="product-reviews__title js-review-tab-btn is-active" data-tab="reviews">Отзывы <span><?= count($arResult["REVIEWS"]) ?></span></button>
			<button class="product-reviews__title js-review-tab-btn" data-tab="questions">Вопрос-ответ <span><?= count($arResult["QUESTIONS"]) ?></span></button>
		</div>
		<?php

		// Отзывы ?>
		<div class="product-reviews__review js-review-tab" data-tab="reviews">
			<? foreach ($arResult["REVIEWS"] as $i => $item) { ?>
				<div class="review-el-continer js-review" <?= $i >= 3 ? 'style="display:none"' : '' ?>>
					<div class="review-el">
						<div class="review-el__img"><?= mb_substr($item['AUTHOR'], 0, 1) ?></div>
						<div class="review-el__content">
							<div class="review-el__top">
								<div class="review-el__title"><?= $item['AUTHOR'] ?></div>
								<time class="review-el__time"><?= FormatDate('x', $item['DATE_CREATE']->getTimestamp()) ?></time>
								<div class="review-el__star">
									<svg width="15" height="15"><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#icon-star-checked"></use></svg>
									<span><?= $item['RATING'] ?>/5</span>
								</div>
							</div>
							<p class="review-el__text"><?= $item['TEXT'] ?></p>
						</div>
					</div>
				</div>
			<? } ?>
			<button class="product-characteristic__link-button link-button js-review-more" <?= count($arResult["REVIEWS"]) <= 3 ? 'style="display:none"' : '' ?>>Показать все отзывы</button>
		</div>
		<?php

		// Вопросы и ответы ?>
		<div class="product-reviews__questions js-review-tab" data-tab="questions" style="display:none;">
			<? foreach ($arResult["QUESTIONS"] as $i => $item) { ?>
				<div class="review-el-continer js-question" <?= $i >= 3 ? 'style="display:none"' : '' ?>>
					<div class="review-el">
						<div class="review-el__img"><?= mb_substr($item['AUTHOR'], 0, 1) ?></div>
						<div class="review-el__content">
							<div class="review-el__top">
								<div class="review-el__title"><?= $item['AUTHOR'] ?></div>
								<time class="review-el__time"><?= FormatDate('x', $item['DATE_CREATE']->getTimestamp()) ?></time>
							</div>
							<p class="review-el__text"><?= $item['QUESTION'] ?></p>
						</div>
					</div>
					<? if (!empty($item['ANSWER'])) { ?>
						<div class="review-answer">
							<div class="review-el__content">
								<div class="review-el__top">
									<div class="review-el__title">Soldout</div>
								</div>
								<p class="review-el__text"><?= $item['ANSWER'] ?></p>
							</div>
						</div>
					<? } ?>
				</div>
			<? } ?>
			<button class="product-characteristic__link-button link-button js-question-more" <?= count($arResult["QUESTIONS"]) <= 3 ? 'style="display:none"' : '' ?>>Показать ещё</button>
			<a class="btn btn--big rating-box__btn js-btn-question" href="javascript:void(0)">
				<span class="btn__label">Задать вопрос</span>
			</a>
		</div>
	</div>
	<?php

	// Панелька рейтинга ?>
	<div class="product-reviews__right">
		<div class="rating-box">
			<div class="rating-box__top">
				<span><?= $arResult["REVIEWS_LIKE"] ?>%</span>
				<p>Пользователям нравится этот товар</p>
			</div>
			<div class="rating-box__rating">
				<div class="rating-box__stars">
					<? for ($i = 1; $i <= $arResult["REVIEWS_AVG"]; $i++) { ?>
						<svg width="16" height="16"><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#icon-star-checked"></use></svg>
					<? } ?>
					<? for (; $i <= 5; $i++) { ?>
						<svg width="16" height="16"><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/tpl/assets/icons/sprite.svg#star"></use></svg>
					<? } ?>
				</div>
				<span class="rating-box__number"><?= floatval($arResult["REVIEWS_AVG"]) ?> / 5</span>
			</div>
			<div class="rating-box__lines">
				<? for ($n = 5; $n > 0; $n--) {
					$cnt = intval($arResult["REVIEWS_STAT"][$n]);
					$pecent = $arResult['PROPERTIES']['RATING_CNT']['VALUE'] > 0 ? $arResult["REVIEWS_STAT"][$n] / $arResult['PROPERTIES']['RATING_CNT']['VALUE'] * 100 : 0; ?>
					<div class="rating-box__lines-row">
						<span class="rating-box__lines-dt"><?= \Cake\Tools::cnt2word($n, ['звезда', 'звезды', 'звезд'])?></span>
						<div class="rating-box__line"><div class="rating-box__line-red" style="width: <?= $pecent ?>%"></div></div>
						<span class="rating-box__lines-dd"><?= $cnt ?></span>
					</div>
				<? } ?>
			</div>
			<a class="btn btn--big rating-box__btn js-btn-review" href="javascript:void(0)"><span class="btn__label">Написать отзыв</span></a>
		</div>
	</div>
</div>
<?php

// Шаблон всплывающего окна с формой для добавления отзыва ?>
<script id="review-form-template" type="text/x-custom-template">
	<form class="modal-registration__form" id="form-review" name="review" action="<?= SITE_TEMPLATE_PATH ?>/components/cake/catalog/catalog/bitrix/catalog.element/offer/review/add-review.ajax.php" method="post">
		<input type="hidden" name="product" value="<?= $arResult['ID'] ?>">
		<input type="hidden" name="sessid" value="<?= bitrix_sessid() ?>">
		<fieldset>
			<div class="input-group">
				<div class="input-group__hint js-form-error total" style="margin-top: -7px;"></div>
			</div>
			<div class="input-group">
				<input class="input-group__input js-input casual-input" type="text" name="fio" placeholder="Имя" />
				<div class="input-group__hint js-form-error"></div>
			</div>
			<div class="input-group">
				<input class="input-group__input js-input casual-input" type="email" name="email" placeholder="Email" />
				<div class="input-group__hint js-form-error"></div>
			</div>


			<div class="input-group">
				<textarea class="input-group__input js-input casual-input" name="text" placeholder="Текст отзыва"></textarea>
				<div class="input-group__hint js-form-error"></div>
			</div>

            <div class="input-group">
                <div class="input-group__label">Оцените товар</div>
                <input class="input-group__input js-input casual-input" type="hidden" name="rating" placeholder="Рейтинг (1-5)" />
                <div class="full-stars">
                    <div class="rating-group">

                        <input name="rating" value="5" type="radio"/>

                        <? for ($i = 1; $i <= 5; $i++) { ?>
                            <label for="fst-<?=$i?>">
                                <svg width="16" height="16" viewBox="0 0 14 13">
                                    <path d="M6.95339 1.35822L8.8902 4.25848L9.01323 4.4427L9.22645 4.50278L12.5833 5.44857L10.4235 8.18682L10.2863 8.36075L10.295 8.58211L10.4328 12.0669L7.1612 10.859L6.95339 10.7822L6.74557 10.859L3.47393 12.0669L3.61174 8.58211L3.6205 8.36075L3.48331 8.18682L1.3235 5.44857L4.68032 4.50278L4.89355 4.4427L5.01657 4.25848L6.95339 1.35822Z" stroke="#E84E0F" stroke-width="1.2" />
                                </svg>
                            </label>
                            <input name="rating" id="fst-<?=$i?>" value="<?=$i?>" type="radio" />
                        <?}?>
                    </div>
                </div>
                <div class="input-group__hint js-form-error"></div>
            </div>
		</fieldset>
	</form>
</script>

<?php

// Шаблон всплывающего окна с формой для добавления вопроса ?>
<script id="question-form-template" type="text/x-custom-template">
	<form class="modal-registration__form" id="form-question" name="question" action="<?= SITE_TEMPLATE_PATH ?>/components/cake/catalog/catalog/bitrix/catalog.element/offer/review/add-question.ajax.php" method="post">
		<input type="hidden" name="product" value="<?= $arResult['ID'] ?>">
		<input type="hidden" name="sessid" value="<?= bitrix_sessid() ?>">
		<fieldset>
			<div class="input-group">
				<div class="input-group__hint js-form-error total"></div>
			</div>
			<div class="input-group">
				<input class="input-group__input js-input casual-input" type="text" name="fio" placeholder="Имя" />
				<div class="input-group__hint js-form-error"></div>
			</div>
			<div class="input-group">
				<textarea class="input-group__input js-input casual-input" name="question" placeholder="Вопрос"></textarea>
				<div class="input-group__hint js-form-error"></div>
			</div>
		</fieldset>
	</form>
</script>