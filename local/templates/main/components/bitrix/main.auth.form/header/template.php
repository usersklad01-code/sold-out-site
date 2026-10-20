<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** ***************************************************************************
 * Форма авторизации
 * @var array $arParams
 * @var array $arResult
 * @global \CMain $APPLICATION
 * @global \CUser $USER
 * ****************************************************************************/
CJSCore::Init('phone_auth');


// Иконка в шапке ?>
<a href="/personal/" class="header-top-menu__lk-btn header-icon-btn <?= $USER->IsAuthorized() ? '' : 'js-show-auth' ?>">
	<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
		<circle cx="8.28154" cy="4.83159" r="3.52162" stroke="black" stroke-width="1.44"/>
		<path d="M15.6534 16.294C15.6534 12.306 12.4205 9.07312 8.43252 9.07312C4.44456 9.07312 1.21167 12.306 1.21167 16.294" stroke="black" stroke-width="1.44"/>
	</svg>
</a>
<script>
	new DjAuth({});
</script>
<?php


// Мобильная иконка
$this->SetViewTarget('mobilePanelAuth'); ?>
<a href="/personal/" class="mob-panel__account-btn icon-btn <?= $USER->IsAuthorized() ? '' : 'js-show-auth' ?>">
	<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
		<circle cx="8.28154" cy="4.83159" r="3.52162" stroke="black" stroke-width="1.44"/>
		<path d="M15.6534 16.294C15.6534 12.306 12.4205 9.07312 8.43252 9.07312C4.44456 9.07312 1.21167 12.306 1.21167 16.294" stroke="black" stroke-width="1.44"/>
	</svg>
</a>
<? $this->EndViewTarget();


// Пункт в мобильном меню
$this->SetViewTarget('mobileMenuAuth'); ?>
<div class="mob-menu__user-links">
	<a href="/personal/" class="mob-menu__user-link icon-user-black <?= $USER->IsAuthorized() ? '' : 'js-show-auth' ?>">
		<span><?= $USER->IsAuthorized() ? 'Личный кабинет' : 'Войти/зарегистрироваться' ?></span>
		<svg width="6" height="11">
			<use xlink:href="/local/templates/main/tpl/assets/icons/sprite.svg#arrow-menu"></use>
		</svg>
	</a>
</div>
<? $this->EndViewTarget();