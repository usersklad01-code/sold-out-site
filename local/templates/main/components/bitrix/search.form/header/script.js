class DjTopSearchForm
{
	constructor(params) {
		this.params = params;
		const _self = this;

		$('#searchTopForm input[name="q"]').on('input', function() {
			_self.onInput($(this));
		});

		$('.js-header-search-all').on('click', function(){
			$('#searchTopForm').submit();
		});
	}

	onInput(oInput) {
		const query = oInput.val().trim();
		if (query.length >= 3) {
			this.loadSearchResult(query);
		} else {
			this.hideResultArea();
		}
	}

	loadSearchResult(query) {
		DJ?.Debug?.log('SEARCH.load', query);
		const _self = this;
		$.ajax({
			url: $('#searchTopForm').attr('action'),
			type: 'GET',
			data: { q: query },
			success: function(response) {
				DJ?.Debug?.log('SEARCH.load-complete', query);
				_self.onSearchLoadComplete(response);
			},
			error: function(xhr, status, error) {
				DJ?.Debug?.log('SEARCH.load-error', error);
				_self.hideResultArea();
			}
		});
	}

	onSearchLoadComplete(response) {
		let arProductCards = $(response).find('.sec-products-catalog__list .product-card');
		if (arProductCards.length === 0) {
			this.hideResultArea();
			$('.error-search-empty').show();
			$('.js-header-search-all').hide();
		} else {
			$('.error-search-empty').hide();
			$('.js-header-search-all').show();
		}

		arProductCards = arProductCards.slice(0, 4);
		arProductCards.find('.product-card-details').hide();
		arProductCards.find('.product-card__btns').hide();
		arProductCards.find('.product-card__btns-other').hide();
		arProductCards.find('.product-card__availabl').hide();

		this.showResultArea(arProductCards);
	}

	hideResultArea() {
		$('#searchTopResult').hide();
	}

	showResultArea(arProductCards) {
		$('#searchTopResult').show();
		$('#searchTopResultItems').empty().append(arProductCards);
	}
}