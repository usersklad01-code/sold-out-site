class DJCatalogList {

	// конструктор
	constructor(params) {
		this.params = params;
		this.initSortPanel();
		this.initViewPanel();
		this.initCountPanel();
		this.initPagePanel();
	}


	// Инициализация панельки сортировки
	initSortPanel() {
		const _self = this;

		$('.js-sort-select').selectize({
			closeAfterSelect: true,
			hideSelected: false,

			onFocus: function() {
				$('.selectize-input input').attr('readonly', true);
				$('.selectize-input input, .selectize-input').css('cursor', 'pointer');
			},

			onChange: function() {
				_self.applySort($('.js-sort-select').val());
				_self.reloadPage();
				return false;
			}
		});
	}

	// запомнить выбранный вариант сортировки
	applySort(sort) {
		DJ?.Debug?.log('SORT.change', sort);
		document.cookie = this.params.cookie_sort + '=' + sort;
	}


	// Инициализация панельки внешнего вида
	initViewPanel() {
		const _self = this;
		$('.js-view-switcher').on('change', function() {
			_self.applyView($(this).attr('id'));
		});
	}

	// запомнить выбранный вариант отображения
	applyView(view) {
		DJ?.Debug?.log('VIEW.change', view);
		document.cookie = this.params.cookie_view + '=' + view;
		$('.js-catalog-list')
			.removeClass('grid-view')
			.removeClass('list-view')
			.addClass(view);
	}


	// Инициализация панельки с количеством товаров
	initPagePanel() {
		const _self = this;

		$('body').on('click', '.js-pagination a', function () {
			const oUrl = $(this);
			_self.reloadPage(
				oUrl.attr('href') ? oUrl.attr('href') : oUrl.data('href'),
				oUrl.data('append') !== 'y'
			);
			return false;
		});
	}


	// Инициализация панельки с количеством товаров
	initCountPanel() {
		const cnt = $("#modef_num");
		if (cnt.length > 0) {
			cnt.html(this.params.product_count).show();
		}
	}


	// перезагрузить страницу (только содержимое блока товаров)
	reloadPage(url = '', isReplace = true) {
		DJ?.Debug?.log('CATALOG.reload', {url:url, replace:isReplace});

		// ссылка
		if (url === undefined || url === '') {
			url = document.location.href;
		}

		// freeze и прокрутка страницы
		const oContainer = $('.js-catalog-list');
		oContainer.css('opacity', 0.3);

		/*if (isReplace) {

			$('html,body').animate(
				{scrollTop: (oContainer.offset().top - 200) + "px"},
				{duration: 800, easing: "linear"}
			);
		}*/

		// перезагрузка списка элементов
		$.ajax({
			url: url,
			success: function (html) {
				DJ?.Debug?.log('CATALOG.reload-complete', '');
				oContainer.css('opacity', 1);

				const items = $(html).find('.js-catalog-list').html();
				if (isReplace) {
					oContainer.html(items);
				} else {
					oContainer.append(items);
				}

				const pager = $(html).find('.js-pagination').html();
				$('.js-pagination').html(pager);
				if (isReplace) {
					history.pushState(null, '', url);
				}
			}
		});
	}
}
function toggleView() {
	var screenWidth = window.innerWidth;
	var catalogList = document.querySelector('.sec-products-catalog__list.js-catalog-list');

	if (screenWidth <= 1024) {
		catalogList.classList.remove('list-view');
		catalogList.classList.add('grid-view');
	}
}

window.addEventListener('load', toggleView);
window.addEventListener('resize', toggleView);