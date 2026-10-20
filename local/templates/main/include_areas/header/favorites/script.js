// глобальный namespace DJ
if (typeof(DJ) === 'undefined') {
	DJ = {};
}

// класс для карточки товара
DJ.Favorites = class {

	// конструктор
	constructor(params) {
		this.params = params;
		this.initEvents();
		this.refreshPageIcons();
	}

	// события сравнения
	initEvents() {
		const _self = this;

		$(document).on("click", ".js-btn-favorites", function() {
			_self.onClickAdd($(this));
			return false;
		});

		$(document).on('refreshFavorites', function(offerID,ids) {
			_self.refreshPageIcons1(offerID, ids);
		});
	}

	onClickAdd(btn) {
		DJ?.Debug?.log("FAVORITES.add-before", btn.data('id'));
		btn.addClass("loading");

		const _self = this;
		$.ajax({
			url: '/local/templates/main/include_areas/header/favorites/toggle.ajax.php',
			data: { id: btn.data('id') },
			dataType: 'json',
			success: function (data) {
				DJ?.Debug?.log("FAVORITES.add-after", data);
				btn.removeClass("loading");
				if (data === undefined || data.success !== true) {
					alert(!!data ? data.message : "Unknown error");
				} else if ( window.location.pathname === '/personal/favorites/' ) {
					location.reload()
				} else {
					_self.params.ids = data.ids;
					_self.refreshPageIcons();
					_self.refreshHeaderIcon();
				}
			}
		});
	}

	// обновить состояние иконки в шапке
	refreshHeaderIcon() {
		const _self = this;
		const ids = _self.params.ids;
		const label = $('.js-favorites-counter');
		let activeCount = 0;
		if (Array.isArray(ids)) {
			activeCount = ids.length;
		} else if (typeof ids === 'object' && ids !== null) {
			activeCount = Object.keys(ids).length;
		}
		if (activeCount > 0) {
			label.show().text(activeCount).parent().addClass("is-active");
		} else {
			label.hide().text('').parent().removeClass("is-active");
		}
	}


	// обновить состояние всех иконок на странице
	refreshPageIcons() {
		const _self = this;
		const ids = _self.params.ids;
		const buttons = document.querySelectorAll('.js-btn-favorites');
		buttons.forEach(button => {
			const buttonId = parseInt(button.getAttribute('data-id'));
			let isActive = false;
			if (Array.isArray(ids)) {
				isActive = ids.includes(buttonId);
			} else if (typeof ids === 'object' && ids !== null) {
				isActive = Object.values(ids).includes(buttonId);
			}
			if (isActive) {
				button.classList.add('is-active');
			} else {
				button.classList.remove('is-active');
			}
		});
		//на всякий случай
			const event = new CustomEvent('favoritesUpdated', { detail: ids });
			document.dispatchEvent(event);
	}
	refreshPageIcons1(offerId,ids1) {
		const _self = this;
		const ids = _self.params.ids;
		const button = document.querySelector('.js-btn-favorites');
		if (button) {
			let isActive = false;
			if (Array.isArray(ids)) {
				isActive = ids.includes(ids1);
			} else if (typeof ids === 'object' && ids !== null) {
				isActive = Object.values(ids).includes(ids1);
			}
			if (isActive) {
				button.classList.add('is-active');
			} else {
				button.classList.remove('is-active');
			}
		}
	}

}