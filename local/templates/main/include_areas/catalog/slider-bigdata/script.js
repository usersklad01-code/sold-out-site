class DJSliderBigData {

	constructor(params) {
		this.params = params;

		const _self = this;
		document.addEventListener("DOMContentLoaded", () => {
			_self.loadBigData();
		});
	}

	// загружаем рекомендации с сайта BigData
	loadBigData()
	{
		let url = this.params.bigdata.url + '?';
		for (let key in this.params.bigdata.params) {
			url += (key + '=' + this.params.bigdata.params[key] + '&');
		}

		DJ?.Debug?.log("BIGDATA.get-recoms", url);
		fetch(url)
			.then(response => response.json())
			.then(result => this.loadSlider(result && result.items || [], result && result.id));
	}

	// Загрузка самолго слайдера
	loadSlider(ids, rid) {
		DJ?.Debug?.log("BIGDATA.load-slider", ids);

		let props = 'action=deferredLoad';
		props += '&bigData=Y';
		props += '&rid=' + rid;
		for (let i in ids) {
			props += '&items[]=' + ids[i];
		}

		fetch(this.params.ajax, {
			'method': 'POST',
			'headers': {'Content-Type': 'application/x-www-form-urlencoded'},
			body: new URLSearchParams(props).toString()
		})
		.then(response => response.text())
		.then(html => this.onLoadSlider(html));
	}

	// Загрузка самолго слайдера
	onLoadSlider(html) {
		DJ?.Debug?.log("BIGDATA.load-slider-complete", '');

		const slider = document.getElementById(this.params.idContainer);
		slider.innerHTML = html;
		this.initSlider(slider);
	}

	// переинициализировать слайдер
	initSlider(slider) {
		DJ?.Debug?.log("BIGDATA.init-slider", slider);
		const swiper = new Swiper(slider.querySelector('.js-slider'), {
			navigation: {
				nextEl: slider.querySelector('.js-slider-btn-next'),
				prevEl: slider.querySelector('.js-slider-btn-prev'),
			},
			slidesPerView: 'auto',
			freeMode: true,
			loop: true,
			breakpoints: {
				768: { freeMode: false},
			},
		});
	}
}