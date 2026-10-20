<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Шапка сайта
 * @global \CMain $APPLICATION
 * ***************************************************************************/
?><!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#fff">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/tpl/assets/img/soldout-logo.svg">
    <?php

	// подключение скриптов и стилей
	\CUtil::InitJSCore(['ajax' , 'popup']);
	$asset = \Bitrix\Main\Page\Asset::getInstance();
	$asset->addCss(SITE_TEMPLATE_PATH . "/tpl/assets/css/template_styles.css");
	$asset->addJs(SITE_TEMPLATE_PATH . '/tpl/assets/js/libs/jquery-3.6.3.min.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/tpl/assets/js/libs/jquery.fancybox.min.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/tpl/assets/js/libs/jquery.inputmask.min.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/tpl/assets/js/libs/nouislider.min.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/tpl/assets/js/libs/starrating.min.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/tpl/assets/js/libs/selectize.min.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/tpl/assets/js/main.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/tpl/assets/js/popup.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/tpl/assets/js/debug.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/tpl/assets/js/ajax.js');
    ?>
    <script async src="<?=SITE_TEMPLATE_PATH?>/tpl/assets/js/libs/swiper.min.js"></script>
    <?
	$APPLICATION->ShowHeadStrings();
	$APPLICATION->ShowHeadScripts();
	$APPLICATION->MoveJSToBody('main');
	$APPLICATION->ShowBodyScripts();
	$APPLICATION->ShowCSS(true);

	// служебные поля для seo
	$APPLICATION->SetPageProperty("canonical", $APPLICATION->GetCurPage());
	$APPLICATION->ShowMeta("robots");
	$APPLICATION->ShowMeta("keywords");
	\Cake\SEO\Meta::noindexPageRobots(); ?>
	<title><?$APPLICATION->ShowTitle();?><?= \Cake\SEO\Meta::getPageSuffix() ?></title>
	<meta name="title" content="<?= $APPLICATION->ShowProperty('title') ?><?= \Cake\SEO\Meta::getPageSuffix() ?>">
	<meta name="description" content="<?= $APPLICATION->ShowProperty('description') ?><?= \Cake\SEO\Meta::getPageSuffix() ?>">
	<link rel="canonical" href="https://<?=$_SERVER['SERVER_NAME']?><? $APPLICATION->ShowProperty("canonical") ?>"/>

    <style>
        .footer__content {
            grid-template-columns: minmax(200px, 250px) minmax(200px, 250px) 200px 300px !important;
        }
        .header {position: relative;}
        .page { margin-top: 20px;}
        .row-fixed {
            position: fixed;
            z-index: 100;
            width: 100%;
            top: 0px;
        }
        .header-bottom-menu__nav-item {font-size:11px !important}
        @media (max-width: 768px) {
            .mobno {
                display:none;
            }
            .mobyes {
                display:flex !important;
            }
            .mobyes2 {
                position:fixed !important;
            }
        }

        @media (min-width: 768px) {
            .mobno {
                display:block1;
            }
            .mobyes {
                display:none;
            }
        }
    </style>

    <script>
        // When the user scrolls the page, execute myFunction
        window.onload  = function() {stickyRow()};
        window.onscroll = function() {stickyRow()};
        function stickyRow() {
            var header = document.getElementById("header2");
            var stickyTop = document.querySelector('.page').offsetTop + 56;
            var headerWidth = '';
            if (header){
                headerWidth = header.offsetWidth;
            }
            if (header){
                // Get the offset position of the navbar
                if (window.pageYOffset > stickyTop) {
                    header.classList.add("row-fixed");
                    header.style.width = headerWidth + 'px';
                } else {
                    header.classList.remove("row-fixed");
                    header.style.width = 'auto';
                }
            }
        }
    </script>
</head>
<body class="body body--scrolling">
	<?php
	// Панель админисрирования ?>
	<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
	<div class="wrapper">
        <header class="header header--visible  mobyes2" id="header" style="position:relative;">
			<?php
			// Моблильное меню (выезжающий экран по бургеру) ?>
			<div class="mob-menu" id="mob-menu">
				<div class="mob-menu__overlay js-mob-menu-toggler"></div>
				<div class="mob-menu__wrapper">
					<div class="mob-menu__container">
						<div class="mob-menu__body">
							<div class="mob-menu__top">
								<? // Логотип ?>
								<div class="mob-menu__top__logo"><? include('include_areas/header/logo/logo.php') ?></div>
								<? // Меню-каталог
								$APPLICATION->ShowViewContent('mobileCatalogMenu'); ?>
							</div>
							<div class="mob-menu__bottom">
                                <div>
                                    <?
                                    // Телефон
                                    $phone = file_get_contents($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/include_areas/footer/phone.html");
                                    $cleanPhone = preg_replace("/[^0-9]/", "", $phone); ?>
                                    <a class="footer-tel link" href="tel:<?= $cleanPhone ?>">
                                        <? $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => SITE_TEMPLATE_PATH . "/include_areas/footer/phone.html"
                                        )); ?>
                                    </a>
                                    <?
                                    // График работы ?>
                                    <div class="footer-tel-info">
                                        <? $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => SITE_TEMPLATE_PATH . "/include_areas/footer/work-time.html"
                                        )); ?>
                                    </div>
                                </div>
								<? // Панель авторизации/регистрации
								$APPLICATION->ShowViewContent('mobileMenuAuth');
								// Панель контактов и обратной связи ?>
                                <div class="footer-contact-panel">
									<? // Форма обратной связи
									include('include_areas/header/feedback-form.php');
									// Список иконок соц.сетей
									include('include_areas/header/social-list.php'); ?>
                                </div>
								<? // Выбор города
								$APPLICATION->ShowViewContent('mobileLocation');
								// Мобильное меню
								$APPLICATION->ShowViewContent('mobileTopMenu');
								// Копирайт и разработка сайта ?>
								<div class="footer-other-info" style="flex-direction: column;">
									<div class="footer-dev"><? include('include_areas/footer/developer.html') ?></div>
									<div class="footer-copyright"><? include('include_areas/footer/copyright.php') ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php

			// Десктопная шапка ?>
			<div class="container">
				<div class="header__top header-top-menu">
					<?php
					// Верхнее меню
					$APPLICATION->IncludeComponent(
						"bitrix:menu",
						"top",
						array(
							"ROOT_MENU_TYPE" => "top",
							"MENU_CACHE_TYPE" => "A",
							"MENU_CACHE_TIME" => "36000000",
							"MENU_CACHE_USE_GROUPS" => "N",
							"MENU_CACHE_GET_VARS" => array(),
							"CACHE_SELECTED_ITEMS" => "N",
							"MAX_LEVEL" => "1",
							"USE_EXT" => "N",
							"DELAY" => "N",
							"ALLOW_MULTI_SELECT" => "N"
						),
						false
					);

					// Иконка бургера ?>
					<div class="header-top-menu__icons">
						<button class="header-top-menu__burger-btn header-icon-btn js-mob-menu-toggler" type="button"><div></div></button>
					</div>
                    <?php

					// Логотип ?>
					<div class="header-top-menu__logo">
						<? include('include_areas/header/logo/logo.php') ?>
                        <div class="header-bottom-menu__catalog-button" data-catalog-toggle="mobile">
                            <div class="catalog-button__three-lines">
                                <img src="<?SITE_TEMPLATE_PATH?>/local/templates/main/tpl/assets/icons/three_line.svg" alt="Описание" width="100" height="100">
                            </div>
                            <span>Каталог</span>
                        </div>
					</div>
					<?php

					// Выбор местоположения
					$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
						"AREA_FILE_SHOW" => "file",
						"PATH" => SITE_TEMPLATE_PATH . "/include_areas/header/location/include.php"
					));

					// Различные иконки в шапке ?>
                    <div class="header-tel">
                        <a class="footer-tel link" href="tel:+<?= $cleanPhone ?>" onclick="ym(53942923,'reachGoal','click_telefon')">
                            <? $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => SITE_TEMPLATE_PATH . "/include_areas/footer/phone.html"
                            )); ?>
                        </a>
                    </div>
					<div class="header-top-menu__icons header-top-menu-desk__icons">
						<?php
						// Иконка Выбора местоположения
						$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_TEMPLATE_PATH . "/include_areas/header/location/icon.php"
						));

						// Иконка избранного
						$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_TEMPLATE_PATH . "/include_areas/header/favorites/include.php"
						));

						// Иконка сравнения
						$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_TEMPLATE_PATH . "/include_areas/header/compare/include.php"
						));

						// корзина в шапке
						$APPLICATION->IncludeComponent(
                            "bitrix:sale.basket.basket.line",
                            "header",
                            array(
                                "COMPONENT_TEMPLATE" => ".default",
                                "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                                "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
                                "SHOW_NUM_PRODUCTS" => "Y",
                                "SHOW_TOTAL_PRICE" => "Y",
                                "SHOW_EMPTY_VALUES" => "Y",
                                "SHOW_PERSONAL_LINK" => "Y",
                                "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                                "SHOW_AUTHOR" => "Y",
                                "PATH_TO_AUTHORIZE" => "",
                                "SHOW_REGISTRATION" => "Y",
                                "PATH_TO_REGISTER" => SITE_DIR."login/",
                                "PATH_TO_PROFILE" => SITE_DIR."personal/",
                                "SHOW_PRODUCTS" => "Y",
                                "SHOW_DELAY" => "N",
                                "SHOW_NOTAVAIL" => "N",
                                "SHOW_IMAGE" => "Y",
                                "SHOW_PRICE" => "Y",
                                "SHOW_SUMMARY" => "Y",
                                "POSITION_FIXED" => "N",
                                "MAX_IMAGE_SIZE" => "70",
                                "HIDE_ON_BASKET_PAGES" => "Y"
                            ),
                            false
                        );

						// Иконка ЛК/авторизации
						$APPLICATION->IncludeComponent(
							"bitrix:main.auth.form",
							"header",
							array(
								"AUTH_FORGOT_PASSWORD_URL" => "/personal/auth/forgot.php",
								"AUTH_REGISTER_URL" => "/personal/auth/register.php",
							)
						); ?>
					</div>
				</div>
			</div>
		</header>
        <header class="header header--visible mobno" id="header2" style="background:none !important">
            <div class="container">
                <div class="header__bottom header-bottom-menu" style="background:#FFFFFF !important">
					<div class="header-bottom-menu__logo"><? include('include_areas/header/logo/logo.php') ?></div>
                    <div class="header-bottom-menu__catalog-button" data-catalog-toggle="desktop">
                        <div class="catalog-button__three-lines">
                            <img src="<?SITE_TEMPLATE_PATH?>/local/templates/main/tpl/assets/icons/three_line.svg" alt="Описание" width="100" height="100">
                        </div>
                        <span>Каталог</span>
                    </div>
					<div class="header-bottom-menu__content">
						<?php
                        $arrSecMenuFilter = array("UF_SECTION_SHOW" => 1);
						// Меню-каталог
						$APPLICATION->IncludeComponent(
							"bitrix:catalog.section.list",
							"catalog.menu",
							Array(
								"ADDITIONAL_COUNT_ELEMENTS_FILTER" => "",
								"ADD_SECTIONS_CHAIN" => "N",
								"CACHE_FILTER" => "Y",
								"CACHE_GROUPS" => "N",
								"CACHE_TIME" => "36000000",
								"CACHE_TYPE" => "A",
								"COUNT_ELEMENTS" => "Y",
								"COUNT_ELEMENTS_FILTER" => "CNT_AVAILABLE",
								"FILTER_NAME" => "arrSecMenuFilter",
								"HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "Y",
								"IBLOCK_ID" => IB_CATALOG,
								"IBLOCK_TYPE" => TYPE_IB_CATALOG,
								"SECTION_CODE" => "",
								"SECTION_FIELDS" => array("NAME"),
								"SECTION_ID" => '',
								"SECTION_URL" => "",
								"SECTION_USER_FIELDS" => array(),
								"SHOW_PARENT_NAME" => "N",
								"TOP_DEPTH" => "2"
							)
						);?>
					</div>

                    <?php // Панелька поиска
                    $APPLICATION->IncludeComponent(
                        "bitrix:search.form",
                        "header",
                        Array(
                            "PAGE" => "#SITE_DIR#search/",
                            "USE_SUGGEST" => "N"
                        )
                    ); ?>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.section.list",
                        "catalog.megamenu",
                        Array(
                            "ADDITIONAL_COUNT_ELEMENTS_FILTER" => "",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "CACHE_FILTER" => "Y",
                            "CACHE_GROUPS" => "N",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "COUNT_ELEMENTS" => "Y",
                            "COUNT_ELEMENTS_FILTER" => "CNT_AVAILABLE",
                            "FILTER_NAME" => "arrSecMegaMenuFilter",
                            "HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "Y",
                            "IBLOCK_ID" => IB_CATALOG,
                            "IBLOCK_TYPE" => TYPE_IB_CATALOG,
                            "SECTION_CODE" => "",
                            "SECTION_FIELDS" => array("NAME"),
                            "SECTION_ID" => '',
                            "SECTION_URL" => "",
                            "SECTION_USER_FIELDS" => array(),
                            "SHOW_PARENT_NAME" => "N",
                            "TOP_DEPTH" => "2"
                        )
                    );?>
				</div>
            </div>
        </header>

		<div class="page">
			<?php
			// Хлебные крошки
			if ($APPLICATION->GetCurDir() !== '/') {
				$APPLICATION->IncludeComponent(
					"bitrix:breadcrumb",
					"main",
					array(
						"COMPONENT_TEMPLATE" => "main",
						"START_FROM" => "0",
						"PATH" => "",
						"SITE_ID" => SITE_ID,
					)
				);
			}