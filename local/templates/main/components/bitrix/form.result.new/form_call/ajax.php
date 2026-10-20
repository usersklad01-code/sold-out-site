<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
CModule::IncludeModule("form");

if (check_bitrix_sessid()) {
    $formErrors = CForm::Check($_POST['WEB_FORM_ID'], $_REQUEST, false, "Y", 'Y');

    // Если не все обязательные поля заполнены
    if (count($formErrors)) {
        echo json_encode(['success' => false, 'errors' => $formErrors]);
    } elseif ($RESULT_ID = CFormResult::Add($_POST['WEB_FORM_ID'], $_REQUEST)) {
        CFormCRM::onResultAdded($_POST['WEB_FORM_ID'], $RESULT_ID);
        CFormResult::SetEvent($RESULT_ID);
        CFormResult::Mail($RESULT_ID);
        echo json_encode(['success' => true, 'errors' => []]);
    } else {
        echo json_encode(['success' => false, 'errors' => $GLOBALS["strError"]]);
    }
} else {
    echo json_encode(['success' => false, 'errors' => ['sessid' => 'Не верная сессия. Попробуйте обновить страницу']]);
}
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';
