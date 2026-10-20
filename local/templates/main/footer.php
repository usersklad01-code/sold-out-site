<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Подвал сайта
 * @global \CMain $APPLICATION
 * ***************************************************************************/ ?>
</div>
<footer class="footer" id="footer">
	<div class="container">
		<div class="footer__content">
			<?php

			// Мобильная панелька внизу экрана ?>
			<div class="footer__mob-panel">
				<div class="mob-panel__inner-content">
					<?php

					// Иконка перехода на главную страницу
					$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
						"AREA_FILE_SHOW" => "file",
						"PATH" => SITE_TEMPLATE_PATH . "/include_areas/header/logo/home.php"
					));

					// Иконка избранного
					$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
						"AREA_FILE_SHOW" => "file",
						"PATH" => SITE_TEMPLATE_PATH . "/include_areas/header/favorites/icon.php",
						'CSS' => 'mob-panel__favorites-btn header-icon-btn'
					));

					// Иконка сравнения
					$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
						"AREA_FILE_SHOW" => "file",
						"PATH" => SITE_TEMPLATE_PATH . "/include_areas/header/compare/icon.php",
						'CSS' => 'mob-panel__statistic-btn icon-btn'
					));

					// Иконка корзины
					$APPLICATION->ShowViewContent('mobileBasket');

					// Иконка ЛК
					$APPLICATION->ShowViewContent('mobilePanelAuth'); ?>
				</div>
			</div>
			<?php

			// Каталог ?>
			<nav class="footer-navigation-links">
				<? $APPLICATION->ShowViewContent('footerCatalogMenu'); ?>
			</nav>
			<?php

				// Меню в подвале
				$APPLICATION->IncludeComponent(
					"bitrix:menu",
					"footer",
					array(
						"ROOT_MENU_TYPE" => "bottom",
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
			// Колонка меню и контактов ?>
			<div class="footer-info-panel">
				<div>
					<?php

					// Телефон
					$phone = file_get_contents($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/include_areas/footer/phone.html");
					$cleanPhone = preg_replace("/[^0-9]/", "", $phone); ?>
					<a class="footer-tel link" href="tel:<?= $cleanPhone ?>" onclick="ym(53942923,'reachGoal','click_telefon')">
						<? $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_TEMPLATE_PATH . "/include_areas/footer/phone.html"
						)); ?>
					</a>
					<?php

					// График работы ?>
					<div class="footer-tel-info">
						<? $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_TEMPLATE_PATH . "/include_areas/footer/work-time.html"
						)); ?>
					</div>

				</div>
				<?php

				// Местоположение
				$APPLICATION->ShowViewContent('footerLocation');

				// Просто текстове описание для seo
                		include('include_areas/footer/footer-desc.html');
				 ?>
			</div>
			<?php

			// Колонка обратной связи и описание ?>
			<div class="footer-contact-panel">
				<? // Форма обратной связи
				include('include_areas/header/feedback-form.php');
				// Список иконок соц.сетей
				include('include_areas/header/social-list.php');
				 // Копирайт и разработчик ?>

				<div class="footer-other-info" style="flex-direction: column;">
					<div class="footer-dev"><? include('include_areas/footer/developer.html') ?></div>
					<div class="footer-copyright"><? include('include_areas/footer/copyright.php') ?></div>
				</div>
			</div>
		</div>
	</div>

    <?$APPLICATION->ShowViewContent('modalLocation');?>
</footer>
</div>

<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(53942923, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        ecommerce:"dataLayer"
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/53942923" style="position:absolute; left:-9999px;" alt="" /></div></noscript>

<script>
    (function(w, d, s, h, id) {
        w.roistatProjectId = id; w.roistatHost = h;
        var p = d.location.protocol == "https:" ? "https://" : "http://";
        var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init?referrer="+encodeURIComponent(d.location.href);
        var js = d.createElement(s); js.charset="UTF-8"; js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);
    })(window, document, 'script', 'cloud.roistat.com', '3397b1b6eecf9c19b2d9e5886c99104d');
</script>
</body>
</html>