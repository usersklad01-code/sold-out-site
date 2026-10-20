// глобальный namespace DJ
if (typeof (DJ) === 'undefined') {
	DJ = {};
}


// класс для отладочных сообщений
DJ.Popup = class {

	static _arPopups = {};
	static getInstance(wndName) {
		if (DJ.Popup._arPopups[wndName] === undefined) {
			DJ.Popup._arPopups[wndName] = new DJ.Popup(wndName);
		}
		return DJ.Popup._arPopups[wndName];
	}

	constructor(wndName) {
		this.isInit = false;
		this._wnd = BX.PopupWindowManager.create(wndName, null, {
			autoHide: true,
			offsetLeft: 0,
			offsetTop: 0,
			overlay: true,
			closeByEsc: true,
			titleBar: true,
			closeIcon: true,
			contentColor: 'white',
			className: 'modal__content popup-' + wndName
		});
	}

	// отобразить всплывающее окно
	show(title= undefined, body = undefined, buttons = undefined, forceReInit = false) {
		if (title !== undefined && (!this.isInit || forceReInit)) {
			this._wnd.setTitleBar(title);
		}
		if (body !== undefined && (!this.isInit || forceReInit)) {
			this._wnd.setContent(body);
		}
		if (buttons !== undefined && (!this.isInit || forceReInit)) {
			this._wnd.setButtons(buttons);
		}
		this.isInit = true;
		this._wnd.show();
		return this;
	}

	downloadContent(url) {
		const _self = this;
		fetch(url,{method: 'post'})
			.then(response => response.text())
			.then(html => {
				_self.setContent(html);
				_self.setFreezeState(false);
			});

		return this;
	}

	sendAjaxForm () {
		if ($('.tel-login').length) { // Проверяем наличие элемента с классом .tel-login
			$('.tel-login').inputmask('remove');
			var phoneNumber = $('.tel-login').val().replace(/\D/g, '');
			if (phoneNumber.length == 11) {
				phoneNumber = '+' + phoneNumber;
			} else {
				phoneNumber = '';
			}
			$('.tel-login').val(phoneNumber);
		}
			//console.log(phoneNumber);
			const form = this._wnd.contentContainer.getElementsByTagName('form')[0] ? this._wnd.contentContainer.getElementsByTagName('form')[0] : $('#form_auth')[0];

			if (!form) {
				return this;
			}

		const _self = this;
		const url = form.getAttribute('action');
		const data = new URLSearchParams(new FormData(form));
		data.append('ajax', 'y');

		fetch(url, {method: 'post', body: data})
			.then(response => response.text())
			.then(html => {
				_self.setContent(html);
				_self.setFreezeState(false);
			});
		var emailInput = $('.email-login');
		console.log(emailInput);
		if(emailInput.length!=0){//проверка почты
			var email = emailInput.val().trim();
			var re = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
			if (email !== '' && !re.test(email)) {
				$('.errortext').append('Некорректный email<br>');
				return;
			}
		}
		return this;
	}

	// поменять содержимое окна
	setContent(html) {
		this._wnd.setContent(html);

		const scripts = this._wnd.contentContainer.getElementsByTagName('script');
		Array.prototype.slice.call(scripts).forEach(function(curScript, index) {
			let newScript = document.createElement('script');
			newScript.text = curScript.text;
			curScript.parentNode.replaceChild(newScript, curScript);
		});

		return this;
	}

	setTitle(title) {
		this._wnd.setTitleBar(title);
		return this;
	}

	setButtons(arButtons) {
		this._wnd.setButtons(arButtons);
		return this;
	}

	// состояние загрузки
	setFreezeState(isFreeze = true) {
		const cont = this._wnd.contentContainer;
		if (!!cont) {
			cont.style.opacity = isFreeze ? 0.3 : 1;
		}

		let btn = this._wnd.contentContainer.getElementsByClassName('btn')[0];
		if (!!btn) {
			if (isFreeze) {
				btn.classList.add('loading');
			} else {
				btn.classList.remove('loading');
			}
		}

		if (!!this._wnd.buttonsContainer) {
			btn = this._wnd.buttonsContainer.getElementsByClassName('btn')[0];
			if (!!btn) {
				if (isFreeze) {
					btn.classList.add('loading');
				} else {
					btn.classList.remove('loading');
				}
			}
		}

		return this;
	}

	// закрыть всплывающее окно
	close() {
		this._wnd.close();
		return this;
	}

	on(event, selector, func) {
		$(this._wnd.contentContainer).on(event, selector, func);
		return this;
	}

}


// Класс для кнопки всплывающего окна
DJ.PopupButton = function (params) {
	DJ.PopupButton.superclass.constructor.apply(this, arguments);
	this.buttonNode = BX.create('DIV', {
		props: {className: 'btn btn-default'},
		style: typeof params.style === 'object' ? params.style : {},
		html: '<span class="btn__label">' + params.text + '</span><div class="btn__loader-icon"><div class="loading-icon js-button-loader"><div></div><div> </div><div></div></div></div>',
		events: this.contextEvents
	});

	if (BX.browser.IsIE()) {
		this.buttonNode.setAttribute('hideFocus', 'hidefocus');
	}
};
BX.extend(DJ.PopupButton, BX.PopupWindowButton);