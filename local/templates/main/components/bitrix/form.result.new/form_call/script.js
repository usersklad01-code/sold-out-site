
function ajaxFormSubmit(event) {
    event.preventDefault();

    var form = event.target;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/local/templates/main/components/bitrix/form.result.new/form_call/ajax.php');
    var sessionID = '<?= bitrix_sessid(); ?>';

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            let errorBlocks = document.querySelectorAll('.error11');
            errorBlocks.forEach(function (block) {
                block.innerHTML = '';
            });
            var inputText = form.querySelector('.js-input');
            var inputValue = inputText.value.trim();
            var numericValue = inputValue.replace(/\D/g, "");
            if (numericValue.length < 11) {
                var errorBlock = form.querySelector('.error11');
                errorBlock.innerHTML = 'Неправильно набран номер';
            } else {
                var newText = "Мы скоро свяжемся с вами!";
                $('.round-form__container').text(newText);

                ym(53942923,'reachGoal','zakazat_zvonok');
            }
        } else {
            console.error('Ошибка выполнения запроса:', xhr.status, xhr.statusText);
        }
    };
    // Устанавливаем заголовок запроса с идентификатором сессии
    xhr.setRequestHeader('X-Bitrix-Csrf-Token', sessionID);
    var formData = new FormData(form);
    xhr.send(formData);
}
var forms = document.querySelectorAll('form[name="SIMPLE_FORM_1"]');
forms.forEach(function(form) {
form.addEventListener('submit', ajaxFormSubmit);
});