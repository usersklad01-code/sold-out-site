// глобальный namespace DJ
if (typeof(DJ) === 'undefined') {
	DJ = {};
}

// класс для карточки товара
DJ.ProductCard = class {
	constructor(params) {
		this.params = params;
        document.addEventListener('favoritesUpdated', this.onFavoritesUpdated.bind(this));
        this.blockBuy.init(this);
		this.blockSliders.init(this);
		this.blockSkuProps.init(this);
		this.blockInfo.init(this);
		this.blockProperties.init(this);
		this.blockReviews.init(this);
	}
    onFavoritesUpdated(event) {
        const ids = event.detail;
        this.blockBuy.refresh(this.getCurrentOfferId(), ids);
    }

	getCurrentOfferId() {
		return this.params.CURRENT_ID;
	}

	setCurrentOfferId(id, ids) {
		DJ?.Debug?.log("PRODUCT.set-sku", id);
		this.params.CURRENT_ID = id;
        this.blockBuy.refresh(id, ids);
		this.blockSliders.refresh(id);
		this.blockSkuProps.refresh(id);
		this.blockInfo.refresh(id);
		this.blockProperties.refresh(id);
		this.blockReviews.refresh(id);
	}

	getOffer(id) {
		return this.params.OFFERS[id];
	}

	getAllOffers() {
		return this.params.OFFERS;
	}


	/** *************************************************************
	 * Блок со слайдерами
	 * **************************************************************/
	blockSliders = {

		// инициализация
		init: function (parent) {
			DJ?.Debug?.log("PRODUCT-SLIDER.init", "");
			this.parent = parent;

			const _self = this;
			$('.js-product-slider').each(function () {
				_self.initSlider($(this));
			});
		},

		// переинициализировать слайдер
		initSlider(oSlider) {
			let leftSlider = oSlider.find('.js-left-slider').get(0);
			let mainSlider = oSlider.find('.js-main-slider').get(0);
			const nexBtn = oSlider.find('.js-btn-next').get(0);
			const prevBtn = oSlider.find('.js-btn-prev').get(0);
			if (!leftSlider || !mainSlider) {
				return;
			}

			DJ?.Debug?.log("PRODUCT-SLIDER.init-slider", oSlider);
			leftSlider = new Swiper(leftSlider, {
				watchSlidesProgress: true,
				allowTouchMove: false,
				breakpoints: {
					320: {
						slidesPerView: 3,
						direction: 'horizontal',
						spaceBetween: 10
					},
					768: {
						slidesPerView: 4,
						direction: 'vertical',
						spaceBetween: 10
					},
				},
				on: {
					touchEnd: function(s,e) {
						let range = 5;
						let diff = s.touches.diff = s.isHorizontal() ? s.touches.currentX - s.touches.startX : s.touches.currentY - s.touches.startY;
						if (diff < range || diff > -range)
							s.allowClick = true;
					}
				},
			});

			mainSlider = new Swiper(mainSlider, {
				watchSlidesProgress: true,
				loop: true,
				slidesPerView: 1,
				navigation: {
					nextEl: nexBtn,
					prevEl: prevBtn,
				},
				thumbs: {
					swiper: leftSlider,
				},
			});
		},

		// обновление слайдера с изображениями
		refresh: function (idOffer) {
			DJ?.Debug?.log("PRODUCT-SLIDER.refresh-sku", idOffer);
			$('.js-product-slider').hide();
			$('.js-product-slider[data-for-sku=' + idOffer + ']').show();
		},
	};


	/** *************************************************************
	 * Блок выбора sku
	 * **************************************************************/
	blockSkuProps = {
		// инициализация
		init: function (parent) {
			DJ?.Debug?.log("PRODUCT-SKUPROPS.init", "");
			this.parent = parent;

			const _self = this;
			$('.js-sku-prop input').on("change", function() {
				const id = _self.getSkuForProps(this);
				_self.parent.setCurrentOfferId(id);
			});
		},

		// подбор sku под выбранные свойства
		getSkuForProps: function (input) {
			const propName = $(input).attr("name");
			const propValue = $(input).attr("value");
			DJ?.Debug?.log("PRODUCT-SKUPROPS.chose", {prop: propName, value:propValue});

			// подбираем sku под выбранные параметры
			const offers = this.parent.getAllOffers();
			for (let i in offers) {
				if (this.checkOfferForProps(offers[i])) {
					return offers[i].ID;
				}
			}

			// если нету sku под все выбранные парамтеры, то выбираем любой sku с параметром, по которому кликнули
			for (let i in offers) {
				if (offers[i].PROPS[propName] == propValue) {
					return offers[i].ID;
				}
			}

			// что-то вообще ничего не удалось подобрать, берем просто первый sku
			for (let i in offers) {
				return offers[i].ID;
			}
		},

		// проверить, подходит ли sku под выбранные параметры
		checkOfferForProps: function(offer) {
			let isGood = true;
			for (let propName in offer.PROPS) {
				if (!$(".js-sku-prop input[name=" + propName + "][value=" + offer.PROPS[propName] + "]").is(":checked")) {
					isGood = false;
				}
			}

			return isGood;
		},

		// расставляем свойства для выбранного sku
		refresh: function(id) {
			DJ?.Debug?.log("PRODUCT-SKUPROPS.refresh", id);

			const offer = this.parent.getOffer(id);
			$('.js-sku-prop').each(function() {
				const propWrapper = $(this);

				const propId = propWrapper.data('prop');
				const offerValue = offer.PROPS['PROP_' + propId];

				propWrapper.find('input[value=' + offerValue + ']').prop("checked", true);
			});
		}
	};


	/** *************************************************************
	 * Блок с основной информацией
	 * **************************************************************/
	blockInfo = {

		// инициализация
		init: function (parent) {
			DJ?.Debug?.log("PRODUCT-INFO.init", "");
			this.parent = parent;
			this.initDescription();
		},

		// обновление слайдера с изображениями
		refresh: function (idOffer) {
			DJ?.Debug?.log("PRODUCT-INFO.refresh", idOffer);

			const offer = this.parent.getOffer(idOffer);
			console.log(offer)
			$(".js-product-title").text(offer.NAME);
			if (offer.XML_ID){
				$(".js-product-article-title").show()
				console.log(offer);
				$(".js-product-article").text(offer.XML_ID);
			}
			else{
				$(".js-product-article").text('');
				$(".js-product-article-title").hide()
			}

			$(".js-product-description .js-txt").html(offer.DESCRIPTION);
			this.checkDescriptionHeight();
		},

		initDescription: function() {
			this.checkDescriptionHeight();
			$(".js-product-description .js-btn").on("click", function() {
				$(".js-product-description").toggleClass("short");
			});
		},

		checkDescriptionHeight: function() {
			const oDsc = $(".js-product-description");
			const txt = oDsc.find(".js-txt").text();

			if (txt == "") {
				oDsc.hide();
				return;
			}
			var maxCharsToShowButton = 200; // Установите максимальное количество символов для отображения кнопки

			$('.js-product-description').each(function() {
				var textContainer = $(this).find('.js-txt');
				var textContent = textContainer.text();
				var charCount = textContent.length;

				if (charCount > maxCharsToShowButton) {
					$(this).find('.js-btn').show(); // Показать кнопку
				} else {
					$(this).find('.js-btn').hide(); // Скрыть кнопку
				}
			});
			oDsc.removeClass("short");
			if (oDsc.height() > 100) {
				oDsc.addClass("short");
			}
		},
	};


	/** *************************************************************
	 * Блок с ценой и покупкой
	 * **************************************************************/
	blockBuy = {

		// инициализация
		init: function (parent) {
			DJ?.Debug?.log("PRODUCT-BUY.init", "");
			this.parent = parent;
		},

		// обновление
        refresh: function (idOffer, ids) {
			DJ?.Debug?.log("PRODUCT-BUY.refresh", idOffer);
			const offer = this.parent.getOffer(idOffer);
			this.refreshPrice(offer);
			this.refreshBuyBtn(offer);
            this.refreshFavoriteAndCompare(offer, ids);
		},

		// блок с ценой
		refreshPrice: function(offer) {
			//console.log(offer.ARTICLE);
			$(".js-product-price").html(offer.PRICE.VALUE);
			$(".js-product-article").html(offer.XML_ID);

			$(".js-product-discount").html(offer.PRICE.DISCOUNT);
			$(".js-product-discount-percent").html("-" + offer.PRICE.DISCOUNT_PERCENT + "%");
			if (offer.PRICE.DISCOUNT > 0) {
				$(".js-product-discount").parent().show();
			} else {
				$(".js-product-discount").parent().hide();
			}
		},

		// блок с кнопкой покупки
		refreshBuyBtn: function(offer) {
			if (offer.PRICE.CAN_BUY) {
				$(".product-head .js-btn-buy")
					.show()
					.data("id", offer.ID)
					.data("name", offer.NAME)
					.data("img", offer.PICTURE)
					.removeClass('btn--gray')
					.prop('disabled', false)
					.find('.btn__label').text("В корзину");
				$(".product-head .js-btn-oneclick")
					.show()
					.data("id", offer.ID);
				$('.product-head .js-prod-available').text('В наличии');
				$('.js-prod-available-check').show();
			} else {
				$(".product-head .js-btn-buy")
					.addClass('btn--gray')
					.prop('disabled', true)
					.find('.btn__label').text("Отсутствует");
				$(".product-head .js-btn-oneclick").hide();
				$('.product-head .js-prod-available').text('Не в наличии');
				$('.js-prod-available-check').hide();
			}
		},

		// сравнение и избранное
        refreshFavoriteAndCompare: function(offer, ids) {

            $(".product-head .js-btn-compare").data('id', offer.ID);
            $(".product-head .js-btn-favorites").data('id', offer.ID);
            $(document).trigger('refreshCompare',offer.ID,ids);
            $(document).trigger('refreshFavorites',offer.ID,ids);
        },
    };


	/** *************************************************************
	 * Блок с характеристиками
	 * **************************************************************/
	blockProperties = {
		shortMode: true,

		// инициализация
		init: function (parent) {
			DJ?.Debug?.log("PRODUCT-PROPS.init", "");
			this.parent = parent;
			this.refresh(parent.getCurrentOfferId());

			const _self = this;
			$('.js-property-more').on('click', function () {
				_self.triggerMode();
			});
		},

		// переключить режим сокращенный/полный
		triggerMode: function () {
			const btn = $('.js-property-more');

			this.shortMode = !this.shortMode;
			this.refresh(this.parent.getCurrentOfferId());
			if (this.shortMode) {
				btn.text("Показать все характеристики");
			} else {
				btn.text("Скрыть характеристики");
			}
			if (this.shortMode) {
				if ($(window).width() <= 1024) {
					$('html, body').scrollTop($('.product-characteristic').offset().top);
				} else {
					$('html, body').scrollTop($('.product-characteristic').offset().top-140);
				}
			}
		},

		// обновления для некоторого sku
		refresh: function (idOffer) {
			DJ?.Debug?.log("PRODUCT-PROPS.refresh-sku", {offer: idOffer, shortMode: this.shortMode});

			let numShow = 0;
			const _self = this;
			$(".js-property-row").hide().each(function () {
				const row = $(this);
				if (row.data("for-sku") == 0 || row.data("for-sku") == idOffer) {
					numShow++;
					if (!_self.shortMode || numShow <= 3) {
						row.show();
					}
				}
			});

			if (numShow <= 3) {
				$('.js-property-more').hide();
			}
		}
	};


	/** *************************************************************
	 * Блок с отзывами и вопросами
	 * **************************************************************/
	blockReviews = {

		// инициализация
		init: function (parent) {
			DJ?.Debug?.log("PRODUCT-REVIEW.init", "");
			this.parent = parent;
			this.initTabs();
			this.initReviewTab();
			this.initQuestionTab();
		},

		// инициализафция табов
		initTabs: function() {
			const _self = this;
			$('.js-review-tab-btn').on('click', function() {
				_self.openTab($(this).data('tab'));
			});
		},

		// инициализация табов
		openTab: function(tab) {
			$('.js-review-tab').hide();
			$('.js-review-tab[data-tab=' + tab + ']').show();

			$('.js-review-tab-btn').removeClass('is-active');
			$('.js-review-tab-btn[data-tab=' + tab + ']').addClass('is-active');
		},

		// обработчики вкладки отзывов
		initReviewTab: function() {
			const _self = this;
			// кнопка "показать еще"
			$('.js-review-more').on('click', function() {
				_self.showMoreReview();
			});

			// добавление отзыва
			$('.js-btn-review').on('click', function() {
				_self.showReviewPopup();
				return false;
			});
		},

		// отобразить еще 3 отзыва
		showMoreReview: function() {
			let items = $('.js-review:hidden');
			for (let i = 0; i < items.length && i < 3; i++) {
				$(items[i]).show();
			}

			if (items.length <= 3) {
				$('.js-review-more').hide();
			}
		},

		// показать форму для отзыва
		showReviewPopup: function() {
			DJ?.Debug?.log("PRODUCT-REVIEW.show-review-form", "");

			let wnd = DJ.Popup.getInstance("review-form");
			wnd.show(
				"Написать отзыв о товаре",
				$('#review-form-template').html(),
				[
					new DJ.PopupButton({
						text: "Отправить",
						events: { click: BX.delegate(this.sendReviewForm, this) }
					})
				]
			);
		},

		// отослать форму с отзывом
		sendReviewForm: function() {
			DJ?.Debug?.log("PRODUCT-REVIEW.send-review-form", "");

			const oForm = $('#form-review');
			oForm.find('button').addClass('loading');
			$.ajax({
				type: "POST",
				url: oForm.attr('action'),
				cache: false,
				contentType: false,
				processData: false,
				data: new FormData(oForm.get(0)),
				dataType : 'json',
				success: function(data){
					DJ?.Debug?.log("PRODUCT-REVIEW.send-review-result", data);
					oForm.find('button').removeClass('loading');
					if (data.success !== true) {
						oForm.find('.js-form-error').text('');
						for (let key in data.errors) {
							if (key === 'total') {
								oForm.find('.js-form-error.total').text(data.errors[key]);
							} else {
								oForm.find('.js-input[name=' + key + '] ~ .js-form-error').text(data.errors[key]);
							}
						}
					} else {
						DJ.Popup.getInstance("review-form").show(
							"Спасибо за ваш отзыв",
							data.message,
							[],
							true
						);
					}
				}
			});
		},

		// обработчики вкладки вопросов и ответов
		initQuestionTab: function() {
			const _self = this;
			$('.js-btn-question').on('click', function() {
				_self.showQuestionPopup();
			});

			$('.js-question-more').on('click', function() {
				_self.showMoreQuestions();
			});
		},

		// показать форму для вопроса
		showQuestionPopup: function() {
			DJ?.Debug?.log("PRODUCT-REVIEW.show-question-form", "");

			let wnd = DJ.Popup.getInstance("questions-form");
			wnd.show(
				"Задать вопрос",
				$('#question-form-template').html(),
				[
					new DJ.PopupButton({
						text: "Отправить",
						events: { click: BX.delegate(this.sendQuestionForm, this) }
					})
				]
			);
		},

		// отослать форму с вопросом
		sendQuestionForm: function() {
			DJ?.Debug?.log("PRODUCT-REVIEW.send-question-form", "");

			const oForm = $('#form-question');
			oForm.find('button').addClass('loading');
			$.ajax({
				type: "POST",
				url: oForm.attr('action'),
				cache: false,
				contentType: false,
				processData: false,
				data: new FormData(oForm.get(0)),
				dataType : 'json',
				success: function(data){
					DJ?.Debug?.log("PRODUCT-REVIEW.send-question-result", data);
					oForm.find('button').removeClass('loading');
					if (data.success !== true) {
						oForm.find('.js-form-error').text('');
						for (let key in data.errors) {
							if (key === 'total') {
								oForm.find('.js-form-error.total').text(data.errors[key]);
							} else {
								oForm.find('.js-input[name=' + key + '] ~ .js-form-error').text(data.errors[key]);
							}
						}
					} else {
						DJ.Popup.getInstance("questions-form").show(
							"Спасибо за ваш вопрос",
							data.message,
							[],
							true
						);
					}
				}
			});
		},

		// отобразить еще 3 вопроса
		showMoreQuestions: function() {
			let items = $('.js-question:hidden');
			for (let i = 0; i < items.length && i < 3; i++) {
				$(items[i]).show();
			}

			if (items.length <= 3) {
				$('.js-question-more').hide();
			}
		},

		// обновления для некоторого sku
		refresh: function (idOffer) {
		}
	};

}