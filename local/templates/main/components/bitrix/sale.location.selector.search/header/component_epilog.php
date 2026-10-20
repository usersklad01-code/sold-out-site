<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Постобработка данных
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * ***************************************************************************/

// Запоминаем выбор в куках
\Cake\Location\UserLocation::getInstance()->setCurrentCity(intval($arResult['LOCATION']['ID']));

// Скрипты (зачем?) ?>
<script>
	$(function () {
		/** инпуты формируются bx js, удаляем предустановленное значение **/
		$('.bx-ui-sls-fake').val('')
		$('.bx-ui-sls-container [disabled="disabled"]').val('')
	})
</script>
