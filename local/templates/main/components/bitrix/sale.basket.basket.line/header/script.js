class BitrixSmallCart {

	constructor(params) {
		DJ?.Debug?.log("BASKET-HEADER.init", params);

		if (window.isHeaderBasketInit) {
			return;
		} else {
			window.isHeaderBasketInit = true;
		}

		this.urlBasket = params.urlBasket;
		this.urlAdd = params.urlAdd;
		this.urlRefresh = params.urlRefresh;
		this.basketItems = params.basketItems;

		this.initEvents();
	}

	initEvents() {
		DJ?.Debug?.log("BASKET-HEADER.init-event", '');
		const _self = this;

		// обновление корзины по событию
		BX.addCustomEvent(window, 'OnBasketChange', function(data) {
			_self.refreshCart(data);
		});

		// кнопк отображения окна с корзиной
		$(document).on('click', '.js-basket-wnd-show', function() {
			_self.showPopupBasket();
			return false;
		});

		// кнопки покупки товаров на странице
		$(document).on('click', '.js-btn-buy', function() {
			_self.addToBasket($(this));
		});

		// кнопки покупки в один клик
		$(document).on('click', '.js-btn-oneclick', function() {
			_self.oneClickShowPopup($(this).data('id'));
		});

		// события самого окна "Покупка в один клик"
		DJ.Popup.getInstance('oneclick-wnd').on('click', '.js-form-submit-btn', function() {
			_self.oneClickSendForm();
			return false;
		});
	}

	addToBasket(btn) {
		let id = btn.data("id");
		if (id <= 0) {
			DJ.Debug.error("ADD-TO-BASKET", "к нопке не привязан id товара, не понятно что добавлять в корзину");
			return;
		}

		let quantity = 1;
		const oForm = btn.closest("form");
		if (oForm.length === 1) {
			const oInput = oForm.find("input[name=quantity]");
			if (!!oInput && oInput.val() > 0) {
				quantity = oInput.val();
			}
		}

		DJ?.Debug?.log("BASKET-HEADER.add-start", {'id': id, 'quantity': quantity, 'prop': btn.data("basket-prop")});
		btn.addClass("loading");
		const _self = this;
		BX.ajax({
			method: 'POST',
			dataType: 'json',
			url: this.urlAdd + '?id=' + id + '&quantity=' + quantity + '&' + btn.data("basket-prop"),
			onsuccess: function (arResult) {
				DJ?.Debug?.log("HEADER-BASKET.add-finished", arResult);
				btn.removeClass("loading");
				if (arResult.STATUS === 'OK') {
					_self.showPopupSuccess(arResult.MESSAGE, arResult.ITEM.NAME, arResult.ITEM.IMG);
					BX.onCustomEvent('OnBasketChange');
				} else {
					_self.showPopupError(arResult.MESSAGE);
				}
			},
		});
	}


	// Отобразить окно с ошибкой
	showPopupError(message) {
		let wnd = DJ.Popup.getInstance("basket-alert");

		const content =  '<div style="max-width:300px;text-align:center;">' + message + '</div>';
		const buttons = [
			new DJ.PopupButton({
				text: "Закрыть",
				events: { click: BX.delegate(wnd.close, wnd) }
			})
		];

		wnd.show("Ошибка", content, buttons, true);
	}

	// Отобразить окно с ошибкой
	showPopupSuccess(message, productName = undefined, productImg = undefined) {
		let wnd = DJ.Popup.getInstance("basket-alert");

		let content = '<div style="max-width:300px;text-align:center;">';
			content += '<h3>' + productName + '</h3>';
			if (!!productImg) {
				content += '<img class="popup-prod-img" src="' + productImg + '" style="max-height:130px;margin:auto;" alt="" />';
			}
		content += '</div>';

		const buttons = [
			new DJ.PopupButton({
				text: "Продолжить покупки",
				events: { click: BX.delegate(wnd.close, wnd) }
			}),
			new DJ.PopupButton({
				text: "Перейти в корзину",
				events: { click: BX.delegate(this.gotoBasket, this) }
			})
		];

		wnd.show(message, content, buttons, true);
	}

	// Отобразить окно с корзиной
	showPopupBasket() {
		DJ?.Debug?.log("BASKET-HEADER.show-popup", this.basketItems);
		let wnd = DJ.Popup.getInstance("basket-items-wnd");

		let content = '<ul class="modal-basket__list">';
		let buttons = [
			new DJ.PopupButton({
				text: "Оформить заказ",
				events: {click: BX.delegate(this.gotoBasket, this)}
			})
		];
		if(this.basketItems.length>0) {
			for (let i in this.basketItems) {
				content += '<li>';
				content += '<a href="' + this.basketItems[i].url + '">' + this.basketItems[i].name + '</a>';
				content += '<p>' + this.basketItems[i].price + '</p>';
				content += '<p><s>' + this.basketItems[i].priceOld + '</s></p>';
				content += '</li>';
			}
            content += '</ul>';
		}
		else {
			content += '<p class="basket-popup-empty">В корзине нет товаров</p>';
			content += '<a class="basket-popup-empty_url" href="/catalog/">Вернуться в каталог</a>';
			buttons="";
		}

		wnd.show("Корзина", content, buttons, true);
	}

	// перейти в корзину
	gotoBasket() {
		document.location.href = this.urlBasket;
	}

	// обновить корзину
	refreshCart(data) {
		const _self = this;
		BX.ajax({
			url: this.urlRefresh,
			method: 'POST',
			dataType: 'json',
			data: data,
			onsuccess: (answer) => {
				if (Array.isArray(answer.basketItems)) {
					_self.basketItems = answer.basketItems;
					const oCounter = $('.js-basket-items-count');
					oCounter.text(answer.basketItems.length);
					if (answer.basketItems.length === 0) {
						oCounter.hide();
					} else {
						oCounter.show();
					}
				}
			}
		});
	}

	// Покупка в один клик
	oneClickShowPopup(id) {
		DJ?.Debug?.log("BASKET-HEADER.show-oneclick", this.basketItems);
		let wnd = DJ.Popup.getInstance("oneclick-wnd");

		const content = '<div id="auth-wnd-form-container">Подождите, идет проверка...</div>';
		const buttons = [
			new DJ.PopupButton({
				text: "Оформить заказ",
				events: {click: BX.delegate(this.oneClickSendForm, this)}
			})
		];

		wnd.show('Покупка в один клик', content, buttons, true)
			.setFreezeState()
			.downloadContent('/personal/order/oneclick.php?id=' + id);
	}

	// Отправка формы покупки
	oneClickSendForm() {
		DJ.Popup.getInstance("oneclick-wnd")
			.setFreezeState()
			.sendAjaxForm();
	}
}