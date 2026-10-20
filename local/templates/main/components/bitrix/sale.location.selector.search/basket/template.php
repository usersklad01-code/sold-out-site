<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Location;

Loc::loadMessages(__FILE__);
?>

<?if(!empty($arResult['ERRORS']['FATAL'])){?>
	<?foreach($arResult['ERRORS']['FATAL'] as $error){?>
		<?ShowError($error)?>
	<?}?>
<?}else{?>
    <? CJSCore::Init(); ?>
	<?$GLOBALS['APPLICATION']->AddHeadScript('/bitrix/js/sale/core_ui_widget.js')?>
	<?$GLOBALS['APPLICATION']->AddHeadScript('/bitrix/js/sale/core_ui_etc.js')?>
	<?$GLOBALS['APPLICATION']->AddHeadScript('/bitrix/js/sale/core_ui_autocomplete.js');?>

    <div id="sls-<?= $arResult['RANDOM_TAG'] ?>"
         class="bx-sls <? if (strlen($arResult['MODE_CLASSES'])): ?> <?= $arResult['MODE_CLASSES'] ?><? endif ?>"
         style="position: relative;">

        <div class="dropdown-block bx-ui-sls-input-block">

            <span class="dropdown-icon"></span>
            <input type="text" autocomplete="off" name="<?= $arParams['INPUT_NAME'] ?>" value="<?= $arResult['VALUE'] ?>"
                   class="dropdown-field" placeholder="<?= Loc::getMessage('SALE_SLS_INPUT_SOME') ?> Ваш город"/>

            <!--			<div class="dropdown-fade2white"></div>-->
            <div class="bx-ui-sls-loader"></div>
            <div class="bx-ui-sls-clear" title="<?= Loc::getMessage('SALE_SLS_CLEAR_SELECTION') ?>"></div>
            <div class="bx-ui-sls-pane"></div>

        </div>

        <script type="text/html" data-template-id="bx-ui-sls-error">
            <div class="bx-ui-sls-error">
                <div></div>
                {{message}}
            </div>
        </script>

        <script type="text/html" data-template-id="bx-ui-sls-dropdown-item">
            <div class="dropdown-item bx-ui-sls-variant" data-delivery-id="20">
                <span class="dropdown-item-text">{{display_wrapped}}</span>
                <? if ($arResult['ADMIN_MODE']): ?>
                    [{{id}}]
                <? endif ?>
            </div>
        </script>

        <div class="bx-ui-sls-error-message">
            <? if (!$arParams['SUPPRESS_ERRORS']): ?>
                <? if (!empty($arResult['ERRORS']['NONFATAL'])): ?>

                    <? foreach ($arResult['ERRORS']['NONFATAL'] as $error): ?>
                        <? ShowError($error) ?>
                    <? endforeach ?>

                <? endif ?>
            <? endif ?>
        </div>

    </div>

    <script>

        if (!window.BX && top.BX) {
            window.BX = top.BX;
        }

        <?if(strlen($arParams['JS_CONTROL_DEFERRED_INIT'])):?>
        if (typeof window.BX.locationsDeferred == 'undefined') {
            window.BX.locationsDeferred = {};
        }
        window.BX.locationsDeferred['<?=$arParams['JS_CONTROL_DEFERRED_INIT']?>'] = function () {
            <?endif?>

            <?if(strlen($arParams['JS_CONTROL_GLOBAL_ID'])):?>
            if (typeof window.BX.locationSelectors == 'undefined') {
                window.BX.locationSelectors = {};
            }
            window.BX.locationSelectors['<?=$arParams['JS_CONTROL_GLOBAL_ID']?>'] =
            <?endif?>

                new BX.Sale.component.location.selector.search(<?=CUtil::PhpToJSObject(array(

                    // common
                    'scope' => 'sls-'.$arResult['RANDOM_TAG'],
                    'source' => $this->__component->getPath().'/get.php',
                    'query' => array(
                        'FILTER' => array(
                            'EXCLUDE_ID' => intval($arParams['EXCLUDE_SUBTREE']),
                            'SITE_ID' => $arParams['FILTER_BY_SITE'] && !empty($arParams['FILTER_SITE_ID']) ? $arParams['FILTER_SITE_ID'] : ''
                        ),
                        'BEHAVIOUR' => array(
                            'SEARCH_BY_PRIMARY' => $arParams['SEARCH_BY_PRIMARY'] ? '1' : '0',
                            'LANGUAGE_ID' => LANGUAGE_ID
                        ),
                    ),

                    'selectedItem' => !empty($arResult['LOCATION']) ? $arResult['LOCATION']['VALUE'] : false,
                    'knownItems' => $arResult['KNOWN_ITEMS'],
                    'provideLinkBy' => $arParams['PROVIDE_LINK_BY'],

                    'messages' => array(
                        'nothingFound' => Loc::getMessage('SALE_SLS_NOTHING_FOUND'),
                        'error' => Loc::getMessage('SALE_SLS_ERROR_OCCURED'),
                    ),

                    // "js logic"-related part
                    'callback' => $arParams['JS_CALLBACK'],
                    'useSpawn' => $arParams['USE_JS_SPAWN'] == 'Y',
                    'initializeByGlobalEvent' => $arParams['INITIALIZE_BY_GLOBAL_EVENT'],
                    'globalEventScope' => $arParams['GLOBAL_EVENT_SCOPE'],

                    // specific
                    'pathNames' => $arResult['PATH_NAMES'],
                    // deprecated
                    'types' => $arResult['TYPES'],

                ), false, false, true)?>);

            <?if(strlen($arParams['JS_CONTROL_DEFERRED_INIT'])):?>
        };
        <?endif?>
        //region Update phone in adaptive
        var phone = 'tel:+78122440088',
            phoneText = '+7 (812) <span>244 00 88</span>';

        <? if ($arResult['LOCATION']['ID'] != 85): ?>
        phone = "tel:88005110898";
        phoneText = '<span>8-800-511-08-98</span></a>';
        <? endif ?>

        $('.sh-mobile__call-phone').attr({
            href: phone
        }).html(phoneText);
        $('.sh-mobile__link.sh-mobile__link--phone').attr({
            href: phone
        });
        //endregion
    </script>


<?}?>
