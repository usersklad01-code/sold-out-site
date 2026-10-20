let form = document.querySelector('#notificationForm'),
    fields = form.querySelectorAll('.js-price-checkbox');

fields.forEach(field => {
    field.addEventListener('change', () => {
        $.ajax({
            url: form.getAttribute('action'),
            data: $(form).serializeArray(),
            method: form.getAttribute('method'),
            dataType: 'json',
            processData: true,
            onsuccess: function (data) {}
        });
    })
})