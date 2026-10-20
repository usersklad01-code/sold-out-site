const SELECTORS = [
    'a[href]',
    'area[href]',
    'input:not([disabled]):not([type="hidden"]):not([aria-hidden])',
    'select:not([disabled]):not([aria-hidden])',
    'textarea:not([disabled]):not([aria-hidden])',
    'button:not([disabled]):not([aria-hidden])',
    'iframe',
    'object',
    'embed',
    '[contenteditable]',
    '[tabindex]:not([tabindex^="-"])'
];
function promoSlider(){
    console.log("init promo slider");
    if(!$('.js-promo-slider').length) return;
    $('.js-promo-slider').each(function() {
        const $slider = $(this);
        const swiper = new Swiper($slider.get(0), {
            navigation: {
                nextEl: '.slider-button-next',
                prevEl: '.slider-button-prev',
            },
            slidesPerView: 1,
            spaceBetween: 20,
            speed: 500,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            breakpoints: {
                280:{
                    slidesPerView:1,
                },
                768: { speed: 1500,slidesPerView:1 },
            },
        });
    });
}

function categorySlider(){
    const windowWidth = $(window).width();
        console.log("init category slider");
        if(!$('.js-category-slider').length) return;
    $('.js-category-slider').each(function() {
        const $slider = $(this).find('.js-slider');
        const $slide = $slider.find('.js-slide');
        let $slidePerView = 'auto'

        if (windowWidth > 768 && $(this).hasClass('js-main-page-category-slider')) {
            $slide.each(function(i) {
                if ((i + 1) % 3 === 0) {
                    $(this).addClass('category-slider__slide--big');
                    $(this).find('.product-card').addClass('product-card--big');
                }
            });
        }
        // if(windowWidth > 1024 && $(this).hasClass('category-basket-slider-js')){
        //     $slidePerView = 'auto'
        // }

        const swiper = new Swiper($slider.get(0), {
            navigation: {
                nextEl: $(this).find('.js-slider-btn-next').get(0),
                prevEl: $(this).find('.js-slider-btn-prev').get(0),
            },
            slidesPerView: 'auto',
            freeMode: true,
            loop: true,
            breakpoints: {
                768: { freeMode: false},
            },
        });
    });
}
function initSelectize(){
    console.log("init selectize");
    if(!$('.js-select').length) return;
    $('.js-select').each(function() {
        $(this).selectize({
            closeAfterSelect: true,
            hideSelected: true,
            onFocus: function() {
                const input = 'selectize-input input',
                    wrapper = 'selectize-input';
                $('.' + input).attr('readonly', true);
                $('.' + input + ', .' + wrapper).css('cursor', 'pointer');
            }
        });
    });
}
function initShowMoreBlockNews(){
    if(!$('.block-news').length) return;
    $(document).on('click','.js-block-news-more',function(){
        const $parent=$(this).closest('.block-news');
        if($parent.hasClass('active')){
            $parent.removeClass('active');
            $(this).text('Показать ещё');
        }else{
            $parent.addClass('active');
            $(this).text('Скрыть');
        }
    })
}

function rangeComponent({ inputMin, inputMax, rangeSlider, digits = 0 }) {
    const min = inputMin.data('min');
    const max = inputMax.data('max');
    const minValue = inputMin.val();
    const maxValue = inputMax.val();
    const inputMinHidden = inputMin.siblings(`input[name="${inputMin.data('for')}"]`);
    const inputMaxHidden = inputMax.siblings(`input[name="${inputMax.data('for')}"]`);

    const inputMask = new Inputmask({
        alias: 'currency',
        min: min,
        max: max,
        groupSeparator: '',
        digits: digits
    });

    inputMask.mask(inputMin);
    inputMask.mask(inputMax);

    noUiSlider.create(rangeSlider, {
        start: [minValue, maxValue],
        connect: true,
        range: {
            min,
            max
        }
    });


    rangeSlider.noUiSlider.on('update', function (values) {
        inputMin.val(values[0]);
        inputMax.val(values[1]);

        if (inputMinHidden.attr('name') === 'arrCatalogFilter_P1_MIN') {
            inputMinHidden.val(values[0].split('.')[0]);
        } else {
            inputMinHidden.val(values[0]);
        }

        if (inputMaxHidden.attr('name') === 'arrCatalogFilter_P1_MAX') {
            inputMaxHidden.val(values[1].split('.')[0]);
        } else {
            inputMaxHidden.val(values[1]);
        }
    });

    rangeSlider.noUiSlider.on('change', resetCheckboxes);

    inputMin.on('change', function() {
        const value = parseInt($(this).val().replace(/\s/g, ''), 10);
        rangeSlider.noUiSlider.set([value, null]);
        inputMinHidden.val(value.toString());
        resetCheckboxes();
    });

    inputMax.on('change', function() {
        const value = parseInt($(this).val().replace(/\s/g, ''), 10);
        rangeSlider.noUiSlider.set([null, value]);
        inputMaxHidden.val(value.toString());
        resetCheckboxes();
    });

    function resetCheckboxes() {
        $('.js-price-checkbox').prop('checked', false);
    };
}
function initCatalogFilter(){
    console.log("init catalog filt");
    if(!$('.js-ct-filter').length || !$('.js-more-items').length ||!$('.js-collapsible-fieldset').length) return;

    $('.js-ct-filter').each(function() {
        const $form = $(this).find('.js-ct-filter-form');
        const $rangeGroups = $(this).find('.js-range-group');
        const $rangeSlider = $rangeGroups.find('.js-range-slider');
        const $priceCheckbox = $(this).find('.js-price-checkbox');
        const $reset = $form.find('.js-reset-form');

        $rangeGroups.each(function() {
            const $rangeSlider = $(this).find('.js-range-slider');
            const $inputMin = $(this).find('.js-input-min');
            const $inputMax = $(this).find('.js-input-max');
            const $checkboxes = $(this).find('.js-range-checkbox');

            rangeComponent({
                inputMin: $inputMin,
                inputMax: $inputMax,
                rangeSlider: $rangeSlider[0],
            });
        });

        $reset.on('click', function() {
            $rangeGroups.each(function() {
                const $rangeSlider = $(this).find('.js-range-slider');
                $rangeSlider[0].noUiSlider.reset();
            });
        });

        $priceCheckbox.on('change', function() {
            $rangeSlider[0].noUiSlider.reset();
        });
    });

    $('.js-more-items').each(function() {
        const $item = $(this).find('.js-more-item');
        const $parent = $(this).closest('[data-parent-container]');
        const $toggleBtn = $parent.find('.js-toggle-btn');
        const visibleCount = $(this).data('visible');
        const buttonTitle = $toggleBtn.data('title');
        const buttonHiddenText = `${buttonTitle} (${$item.length - visibleCount})`;
        const buttonOpenText = 'Скрыть';

        let isOpen = false;

        $toggleBtn.text(`${buttonHiddenText}`);
        $item.slice(visibleCount).addClass('hidden');

        if (visibleCount >= $item.length) {
            $toggleBtn.addClass('hidden');
            return;
        }

        $toggleBtn.on('click', function() {
            isOpen = !isOpen;
            $item.slice(visibleCount).toggleClass('hidden', !isOpen);

            if (isOpen) {
                $(this).text(buttonOpenText);
            } else {
                $(this).text(`${buttonHiddenText}`);
            }
        });
    });

    $('.js-collapsible-fieldset').each(function() {
        const $toggler = $(this).find('.js-toggler');
        const $content = $(this).find('.js-content');

        $toggler.on('click', function() {
            $(this).toggleClass('active');

            if ($(this).hasClass('active')) {
                $content.slideUp();
            } else {
                $content.slideDown();
            }
        });
    });
}
function initGallerySmall(){
    console.log("init gallery block");
    if(!$('[data-fancybox="gallery-item"]').length) return;
    $('[data-fancybox="gallery-item"]').fancybox({
        buttons: [
            "zoom",
            "close",
        ],
        'speedIn': 600,
        'speedOut': 200,
        'overlayShow': false,
        loop: false,
    });
}
function initCollapsibleBlock(){
    if(!$('.js-collapsible-block').length) return;
    console.log("init collapsible block");
    $('.js-collapsible-block').each(function() {
        const $toggler = $(this).find('.js-collapsible-toggler');
        const $content = $(this).find('.js-collapsible-content').get(0);
        const $icon = $(this).find('.js-collapsible-icon').get(0);

        $toggler.on('click', function() {
            $(this).toggleClass('active');

            if ($content.style.maxHeight) {
                $content.style.maxHeight = null;
            } else {
                $content.style.maxHeight = $content.scrollHeight + 'px';
            }
        });
    });
}
class ScrollLock {
    constructor() {
        this._iosChecker = iosChecker;
        this._lockClass = this._iosChecker() ? 'scroll-lock-ios' : 'scroll-lock';
        this._scrollTop = null;
        this._fixedBlockElements = document.querySelectorAll('[data-fix-block]');
    }

    _getScrollbarWidth() {
        return window.innerWidth - document.documentElement.clientWidth;
    }

    _getBodyScrollTop() {
        return (
            self.pageYOffset ||
            (document.documentElement && document.documentElement.ScrollTop) ||
            (document.body && document.body.scrollTop)
        );
    }

    disableScrolling() {
        this._scrollTop = document.body.dataset.scroll = document.body.dataset.scroll ? document.body.dataset.scroll : this._getBodyScrollTop();
        if (this._getScrollbarWidth()) {
            document.body.style.paddingRight = `${this._getScrollbarWidth()}px`;
            this._fixedBlockElements.forEach((block) => {
                block.style.paddingRight = `${this._getScrollbarWidth()}px`;
            });
        }
        document.body.style.top = `-${this._scrollTop}px`;
        document.body.classList.add(this._lockClass);
    }

    enableScrolling() {
        document.body.classList.remove(this._lockClass);
        window.scrollTo(0, +document.body.dataset.scroll);
        document.body.style.paddingRight = null;
        document.body.style.top = null;
        this._fixedBlockElements.forEach((block) => {
            block.style.paddingRight = null;
        });
        document.body.removeAttribute('data-scroll');
        this._scrollTop = null;
    }
}
class FocusLock {
    constructor() {
        this._lockedSelector = null;
        this._focusableElements = null;
        this._endElement = null;
        this._selectors = SELECTORS;

        this._documentKeydownHandler = this._documentKeydownHandler.bind(this);
    }

    _documentKeydownHandler(evt) {
        const activeElement = document.activeElement;
        if (evt.key === 'Tab') {
            if (!this._focusableElements.length) {
                evt.preventDefault();
                activeElement.blur();
                return;
            }
            if (this._focusableElements.length === 1) {
                evt.preventDefault();
                this._focusableElements[0].focus();
                return;
            }
            if (this._focusableElements.length > 1 && !activeElement.closest(this._lockedSelector)) {
                evt.preventDefault();
                this._focusableElements[0].focus();
                return;
            }
        }
        if (evt.key === 'Tab' && !evt.shiftKey && activeElement === this._focusableElements[this._focusableElements.length - 1]) {
            evt.preventDefault();
            this._focusableElements[0].focus();
        }
        if (evt.key === 'Tab' && evt.shiftKey && activeElement === this._focusableElements[0]) {
            evt.preventDefault();
            this._focusableElements[this._focusableElements.length - 1].focus();
        }
    }

    lock(lockedSelector, startFocus = true) {
        this.unlock();
        this._lockedSelector = lockedSelector;
        const lockedElement = document.querySelector(this._lockedSelector);
        if (!lockedElement) {
            return;
        }
        this._focusableElements = lockedElement.querySelectorAll(this._selectors);
        this._endElement = document.activeElement;
        const startElement = lockedElement.querySelector('[data-focus]') || this._focusableElements[0];
        if (this._endElement) {
            this._endElement.blur();
        }
        if (startElement && startFocus) {
            startElement.focus();
        }
        document.addEventListener('keydown', this._documentKeydownHandler);
    }

    unlock(returnFocus = true) {
        if (this._endElement && returnFocus) {
            this._endElement.focus();
        }
        this._lockedSelector = null;
        this._focusableElements = null;
        this._endElement = null;
        document.removeEventListener('keydown', this._documentKeydownHandler);
    }
}
window.focusLock = new FocusLock();

class Modals {
    constructor(settings = {}) {
        this._scrollLock = new ScrollLock();
        this._focusLock = new FocusLock();

        this._modalOpenElements = document.querySelectorAll('[data-open-modal]');
        this._openedModalElement = null;
        this._modalName = null;
        this._enableScrolling = true;
        this._settingKey = 'default';

        this._settings = settings;
        this._preventDefault = this._settings[this._settingKey].preventDefault;
        this._stopPlay = this._settings[this._settingKey].stopPlay;
        this._lockFocus = this._settings[this._settingKey].lockFocus;
        this._startFocus = this._settings[this._settingKey].startFocus;
        this._focusBack = this._settings[this._settingKey].focusBack;
        this._eventTimeout = this._settings[this._settingKey].eventTimeout;
        this._openCallback = this._settings[this._settingKey].openCallback;
        this._closeCallback = this._settings[this._settingKey].closeCallback;
        this._continueScroll = this._settings[this._settingKey].continueScroll;

        this._documentKeydownHandler = this._documentKeydownHandler.bind(this);
        this._documentClickHandler = this._documentClickHandler.bind(this);
        this._modalClickHandler = this._modalClickHandler.bind(this);

        this._init();
    }

    _init() {
        if (this._modalOpenElements.length) {
            document.addEventListener('click', this._documentClickHandler);
        }
    }

    _setSettings(settingKey = this._settingKey) {
        if (!this._settings[settingKey]) {
            return;
        }

        this._preventDefault =
            typeof this._settings[settingKey].preventDefault === 'boolean'
                ? this._settings[settingKey].preventDefault
                : this._settings[this._settingKey].preventDefault;
        this._stopPlay =
            typeof this._settings[settingKey].stopPlay === 'boolean'
                ? this._settings[settingKey].stopPlay
                : this._settings[this._settingKey].stopPlay;
        this._lockFocus =
            typeof this._settings[settingKey].lockFocus === 'boolean'
                ? this._settings[settingKey].lockFocus
                : this._settings[this._settingKey].lockFocus;
        this._startFocus =
            typeof this._settings[settingKey].startFocus === 'boolean'
                ? this._settings[settingKey].startFocus
                : this._settings[this._settingKey].startFocus;
        this._focusBack =
            typeof this._settings[settingKey].lockFocus === 'boolean'
                ? this._settings[settingKey].focusBack
                : this._settings[this._settingKey].focusBack;
        //
        this._continueScroll =
            typeof this._settings[settingKey].continueScroll === 'boolean'
                ? this._settings[settingKey].continueScroll
                : this._settings[this._settingKey].continueScroll;
        //
        this._eventTimeout =
            typeof this._settings[settingKey].eventTimeout === 'number'
                ? this._settings[settingKey].eventTimeout
                : this._settings[this._settingKey].eventTimeout;
        this._openCallback = this._settings[settingKey].openCallback || this._settings[this._settingKey].openCallback;
        this._closeCallback = this._settings[settingKey].closeCallback || this._settings[this._settingKey].closeCallback;
    }

    _documentClickHandler(evt) {
        const target = evt.target;

        if (!target.closest('[data-open-modal]')) {
            return;
        }

        evt.preventDefault();

        this._modalName = target.closest('[data-open-modal]').dataset.openModal;

        if (!this._modalName) {
            return;
        }

        this.open();
    }

    _documentKeydownHandler(evt) {
        const isEscKey = evt.key === 'Escape' || evt.key === 'Esc';

        if (isEscKey) {
            evt.preventDefault();
            this.close(document.querySelector('.modal.is-active').dataset.modal);
        }
    }

    _modalClickHandler(evt) {
        const target = evt.target;

        if (!target.closest('[data-close-modal]')) {
            return;
        }

        this.close(target.closest('[data-modal]').dataset.modal);
    }

    _addListeners(modal) {
        modal.addEventListener('click', this._modalClickHandler);
        document.addEventListener('keydown', this._documentKeydownHandler);
    }

    _removeListeners(modal) {
        modal.removeEventListener('click', this._modalClickHandler);
        document.removeEventListener('keydown', this._documentKeydownHandler);
    }

    _stopInteractive(modal) {
        if (this._stopPlay) {
            modal.querySelectorAll('video, audio').forEach((el) => el.pause());
            modal.querySelectorAll('[data-iframe]').forEach((el) => {
                el.querySelector('iframe').contentWindow.postMessage('{"event": "command", "func": "pauseVideo", "args": ""}', '*');
            });
        }
    }

    _autoPlay(modal) {
        modal.querySelectorAll('[data-iframe]').forEach((el) => {
            const autoPlay = el.closest('[data-auto-play]');
            if (autoPlay) {
                el.querySelector('iframe').contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
            }
        });
    }

    open(modalName = this._modalName) {
        const modal = document.querySelector(`[data-modal="${modalName}"]`);

        if (!modal || modal.classList.contains('is-active')) {
            return;
        }

        document.removeEventListener('click', this._documentClickHandler);

        this._openedModalElement = document.querySelector('.modal.is-active');

        if (this._openedModalElement) {
            this._enableScrolling = false;
            this.close(this._openedModalElement.dataset.modal);
        }

        this._setSettings(modalName);
        modal.classList.add('is-active');

        if (!this._openedModalElement && !this._continueScroll) {
            this._scrollLock.disableScrolling();
        }

        if (this._openCallback) {
            this._openCallback();
        }

        if (this._lockFocus) {
            this._focusLock.lock('.modal.is-active', this._startFocus);
        }

        setTimeout(() => {
            this._addListeners(modal);
            this._autoPlay(modal);
            document.addEventListener('click', this._documentClickHandler);
        }, this._eventTimeout);
    }

    close(modalName = this._modalName) {
        const modal = document.querySelector(`[data-modal="${modalName}"]`);
        document.removeEventListener('click', this._documentClickHandler);

        if (!modal || !modal.classList.contains('is-active')) {
            return;
        }

        if (this._lockFocus) {
            this._focusLock.unlock(this._focusBack);
        }

        modal.classList.remove('is-active');
        this._removeListeners(modal);
        this._stopInteractive(modal);

        if (this._closeCallback) {
            this._closeCallback();
        }

        if (this._enableScrolling) {
            setTimeout(() => {
                this._scrollLock.enableScrolling();
            }, this._eventTimeout);
        }

        setTimeout(() => {
            document.addEventListener('click', this._documentClickHandler);
        }, this._eventTimeout);

        this._setSettings('default');
        this._enableScrolling = true;
    }
}

function initRating(){
    const $rating=$('.my-rating');
    if(!$rating.length) return;
    $rating.starRating({
        starSize: 16,
        initialRating: 5,
        callback: function(currentRating, $el){
            // make a server call here
        }
    });
    console.log('Init rating');
}
function initModalsWindow(){
    console.log("init modals");
    let modals;

// Здесь реализован пример открытия модалки через колбэк закрытия
// const openModalInCloseCallback = (name, context = this) => {
//   context._enableScrolling = false;
//   context._setSettings('default');
//   modals.open(name);
// };
//
// function closeCallback(context = this) {
//   console.log(this)
//   openModalInCloseCallback('is-city');
// }
// function openCallback(context = this){
//     console.log(this)
// }

    const settings = {
        'default': {
            preventDefault: true,
            stopPlay: true,
            lockFocus: true,
            startFocus: true,
            focusBack: true,
            eventTimeout: 400,
            openCallback: false,
            closeCallback: false,
            continueScroll: false,
        },
        'enter':{
            preventDefault: true,
            stopPlay: true,
            lockFocus: true,
            startFocus: true,
            focusBack: true,
            eventTimeout: 400,
            openCallback: false,
            closeCallback: false,
            continueScroll: true,
        },
        'basket':{
            preventDefault: true,
            stopPlay: true,
            lockFocus: true,
            startFocus: true,
            focusBack: true,
            eventTimeout: 400,
            openCallback: false,
            closeCallback: false,
            continueScroll: true,
        }
    };
    const initModals = () => {
        const modalElements = document.querySelectorAll('.modal');
        if (modalElements.length) {
            modalElements.forEach((el) => {
                setTimeout(() => {
                    el.classList.remove('modal--preload');
                }, 100);
            });
        }

        modals = new Modals(settings);
        console.log(modals)
    };
    initModals();
}


const iosChecker = () => {
    return [
            'iPad Simulator',
            'iPhone Simulator',
            'iPod Simulator',
            'iPad',
            'iPhone',
            'iPod'
        ].includes(navigator.platform)
        // iPad on iOS 13 detection
        || (navigator.userAgent.includes('Mac') && 'ontouchend' in document);
};
function  initHeader(){
    const $header = $('#header');
    const $headerSearch = $('.js-header-search');
    const $mobMenu = $('#mob-menu');
    if(!($header.length||$headerSearch.length||$mobMenu.length))return;
    var directionScroll = []
    console.log("init burger");
    $('.js-toggle-header-search').on('click', function() {
        $headerSearch.toggleClass('open');
        $headerSearch.find('input').focus();
        const mouseupHandler = function(e) {
            if (!$headerSearch.is(e.target) && $headerSearch.has(e.target).length === 0) {
                $headerSearch.removeClass('open');
                $('.search-page-result').css('display', 'none');
                $(document).off('mouseup', mouseupHandler);
            }
        };

        $(document).on('mouseup', mouseupHandler);
    });

    $('.js-mob-menu-toggler').on('click', function() {
        $mobMenu.toggleClass('is-open');
        $header.toggleClass('header--mobile');
        $('.js-mob-menu-toggler').toggleClass('open');

        if ($mobMenu.hasClass('is-open')) {
            $('body').addClass('lock');
        } else {
            $('body').removeClass('lock');
            $('.js-mob-submenu').removeClass('is-open');
        }
    });
    /*$(document).on('scroll', function (e) {
        directionScroll.push($(document).scrollTop())
        if (directionScroll[0] < directionScroll[1]) {
            directionScroll = directionScroll.slice(0, 0)
            if (
                $(document).scrollTop() > 150
            ) {
                $(document).find('.header').removeClass('header--visible')
                $('body').removeClass('body--scrolling');
            }
        }
        if (directionScroll[0] >= directionScroll[1]) {
            directionScroll = directionScroll.slice(0, 0)
            $(document).find('.header').addClass('header--visible')
            $('body').addClass('body--scrolling');
        }
    })*/
    $('.js-mob-submenu-toggler').on('click', function() {
        const submenuId = $(this).data('for');
        const $submenu = $(`.js-mob-submenu[data-submenu-id=${submenuId}]`);
        $submenu.toggleClass('is-open');
        $('.js-mob-submenu-toggler').toggleClass('open');
    });

    let timeout;
    let lastScrollTop = 0;

  /*  $(document).on('scroll', function() {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            const scrollDistance = window.scrollY;

            if (scrollDistance >= lastScrollTop) {
                // to bottom
                $header.addClass('header--hidden');
            } else {
                // to top
                $header.removeClass('header--hidden');
            }

            if (scrollDistance === 0) {
                $header.removeClass('header--hidden');
            }

            lastScrollTop = scrollDistance;
        }, 30);
    });*/
}

function initFooter(){
    const windowWidth = $(window).width();
    const $footer = $('#footer');
    console.log("init footer func");
    if(!$footer.length) return;
    const $navList = $footer.find('.js-nav-list');
    const visibleCols = 3;
    if (windowWidth > 1024) {
        $navList.filter(function(i) {
            return i + 1 > visibleCols;
        }).addClass('hidden');
    } else {
        $navList.each(function() {
            $(this).removeClass('hidden');
        });
    }
}
function initCatalogProducts(){
    DJ?.Debug?.log('CATALOG-LIST.init', '');

    $('.js-ct-filter-toggler').on('click', function() {
        const oFilter = $('#catalog-filter');
        oFilter.toggleClass('is-open');
        if (oFilter.hasClass('is-open')) {
            $('body').addClass('lock');
        } else {
            $('body').removeClass('lock');
        }
    });
}
function initCompareModule(){
    const compareBigCards = document.querySelector('.compare-cards-js')
    const compareSmallCards = document.querySelector('.compare-small-js')
    const compareContent = document.querySelector('.compare__content')
    console.log("init compare module");
    if (!compareBigCards || !compareSmallCards || !compareContent) {
        return
    }

    window.addEventListener('scroll', ()=>{
        if(document.documentElement.scrollTop > 380){
            compareSmallCards.classList.add('is-active')
        }else{
            compareSmallCards.classList.remove('is-active')
        }
    })


    function setCentral() {
        const containerStandart = document.querySelector('.container:not(.container--compare)')
        const containerCompare = document.querySelector('.container--compare')
        if (!containerCompare || !containerStandart || !window.matchMedia("(min-width: 1280px)").matches) {
            return
        }
        const paddingOffset = parseInt(window.getComputedStyle(containerStandart).paddingLeft);
        const leftOffset = containerStandart.getBoundingClientRect().left + paddingOffset
        containerCompare.style.setProperty('--left', leftOffset + 'px')
    }

    setCentral()

    function setScrollSmallCards() {
        const containerScrolled = document.querySelector('.compare-container-js')
        if (!containerScrolled) {
            return
        }
        containerScrolled.addEventListener('scroll', scrollSmallCards)
        function scrollSmallCards(e){
            compareSmallCards.scrollTo(e.currentTarget.scrollLeft, 0);

        }
    }
    setScrollSmallCards()
}
$( document ).ready(function() {
    initModalsWindow();
    setTimeout(promoSlider, 500);
    setTimeout(categorySlider, 500);
    initSelectize();
    initCatalogFilter();
    initGallerySmall();
    initCollapsibleBlock();
    initRating();
    initHeader();
    initFooter();
    initCatalogProducts();
    initCompareModule();
    initShowMoreBlockNews();
});