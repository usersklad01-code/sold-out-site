<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(false);
?>

<div class="contacts-page__info">
	<?if(!empty($arResult['PROPERTIES']['SUBTITLE']['VALUE'])):?>
		<span> <b><?=$arResult['PROPERTIES']['SUBTITLE']['~VALUE']?></b></span>
	<?endif?>

    <div class="contacts-page__info-item" itemscope itemtype="https://schema.org/Organization">
		<?if(!empty($arResult['PROPERTIES']['ADDRESS']['VALUE'])):?>
            <address class="contacts-page__address" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                <span itemprop="streetAddress"><?= $arResult['PROPERTIES']['ADDRESS']['~VALUE'] ?></span>
            </address>
        <?endif?>

		<?if(!empty($arResult['PROPERTIES']['PHONE']['VALUE'])):?>
			<?$cleanPhone = str_replace(array('(', ')', ' ', '-'), '', $arResult['PROPERTIES']['PHONE']['VALUE']); ?>
            <a class="contacts-page__tel link" href="tel:<?= $cleanPhone ?>" onclick="ym(53942923,'reachGoal','click_telefon')" itemprop="telephone"><b><?= $arResult['PROPERTIES']['PHONE']['~VALUE'] ?></b></a>
		<?endif?>

		<?if(!empty($arResult['PROPERTIES']['SCHEDULE']['VALUE'])):?>
            <span itemprop="openingHours"><b><?= $arResult['PROPERTIES']['SCHEDULE']['~VALUE'] ?></b></span>
		<?endif?>
	</div>
</div>

<div>
	<?if(!empty($arResult['PROPERTIES']['COOR_LAT']['VALUE'])):?>
		<div class="contacts-page__map" id="contacts-map"></div>
	<?endif?>

	<?if(!empty($arResult['PROPERTIES']['PICTURES']['VALUE'])):?>
		<div class="contacts-page__gallery-small">
			<div class="gallery-small">
				<div class="gallery-small__container">
					<?if(count($arResult['PROPERTIES']['PICTURES']['VALUE']) > 1):?>
						<?$count = 1;?>
						<?foreach($arResult['DISPLAY_PROPERTIES']['PICTURES']['FILE_VALUE'] as $photo):?>
							<div class="gallery-small__item gallery-small__item--<?=$count?>">
								<a data-fancybox="gallery-item" href="<?=$photo['SRC']?>">
									<img src="<?=$photo['SRC']?>" alt="<?=$photo['ALT']?>" loading="lazy">
								</a>
							</div>

							<?$count++?>
						<?endforeach?>
					<?else:?>
						<div class="gallery-small__item gallery-small__item--1">
							<a data-fancybox="gallery-item" href="<?=$arResult['DISPLAY_PROPERTIES']['PICTURES']['FILE_VALUE']['SRC']?>">
								<img src="<?=$arResult['DISPLAY_PROPERTIES']['PICTURES']['FILE_VALUE']['SRC']?>" alt="<?=$arResult['DISPLAY_PROPERTIES']['PICTURES']['FILE_VALUE']['ALT']?>" loading="lazy">
							</a>
						</div>
					<?endif?>
				</div>
			</div>
		</div>
	<?endif?>
</div>


<?if(!empty($arResult['PROPERTIES']['COOR_LAT']['VALUE'])){?>
	<script>
	    document.addEventListener("DOMContentLoaded", function () {
	        var mapContainer = document.querySelector("#contacts-map");
	        var mapCenter = [<?=$arResult['PROPERTIES']['COOR_LAT']['VALUE']?>, <?=$arResult['PROPERTIES']['COOR_LGT']['VALUE']?>];
	        var mapZoom = <?=$arResult['PROPERTIES']['COOR_ZOOM']['VALUE']?>;

	        ymaps.ready(function () {
	            map = new ymaps.Map(mapContainer, {
	                center: mapCenter,
	                zoom: mapZoom,
                    controls: [],
	            });

	            var placemark = new ymaps.Placemark(mapCenter, {
                    hintContent: '<?=$arResult['PROPERTIES']['ADDRESS']['VALUE']?>',
                    balloonContent: '<?=$arResult['PROPERTIES']['ADDRESS']['VALUE']?>',
                }, {
                    iconLayout: 'default#image',
                    iconImageHref: '/local/templates/main/tpl/assets/img/map-point.svg',
                    iconImageSize: [50, 50],
                    iconImageOffset: [-5, -38]
	            });

	            map.geoObjects.add(placemark);
	        });
	    }, false);
	</script>
<?}?>
<script type="application/ld+json">
    {
        "@context": "http://schema.org/",
        "@type": "Organization",
        "name": "SoldOut",
        "logo": "https://soldout.ru/local/templates/main/tpl/assets/img/logo.svg",
        "image": "https://soldout.ru/local/templates/main/tpl/assets/img/logo.svg",
        "url": "https://soldout.ru/contacts/",
        "address":{
            "@type": "PostalAddress",
            "streetAddress": "пр. Лиговский д.10/118 оф.211",
            "addressLocality": "Санкт-Петербург",
            "addressRegion": "Санкт-Петербург",
            "postalCode": "191036",
            "addressCountry": "Russia"
        },
        "telephone":"+7 812 502 71 20"
    }
</script>