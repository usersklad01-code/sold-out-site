class DjAuth {

	// конструктор
	constructor(params) {
		this.params = params;
		this.wnd = DJ.Popup.getInstance("auth-wnd");
		this.initEvents();
	}

	// инициализация обработчиков и кнопок
	initEvents() {
		const _self = this;

		$(document).on('click', '.js-show-auth', function () {
			_self.showPopup('/personal/auth/', "Войти");
			return false;
		});

		$('.popup-auth-wnd').on('click', '.js-url-auth', function(){
			_self.showPopup($(this).attr('href'), "Войти");
			return false;
		});

		$('.popup-auth-wnd').on('click', '.js-url-register', function(){
			_self.showPopup($(this).attr('href'), "Регистрация");
			return false;
		});

		$('.popup-auth-wnd').on('click', '.js-url-forgot', function(){
			_self.showPopup($(this).attr('href'), "Смена пароля");
			return false;
		});

		$('.popup-auth-wnd').on('click', '.js-btn-submit', function(){
			_self.sendAjaxForm();
			return false;
		});

		$('.auth-main-wp').on('click', '.js-btn-submit', function(){
			_self.sendAjaxForm();
			return false;
		});
	}

	// Загрузить и отобразить ajax-форму
	showPopup(url, wndTitle) {
		DJ?.Debug?.log('AUTH.show-auth-wnd', {'url': url, 'title': wndTitle});

		const content = '<div id="auth-wnd-form-container">Подождите, идет проверка...</div>';
		this.wnd
			.show(wndTitle, content, [], true)
			.setFreezeState()
			.downloadContent(url + '?ajax=y');
	}

	// отправка формы
	sendAjaxForm() {
		this.wnd
			.setFreezeState()
			.sendAjaxForm();
	}

}