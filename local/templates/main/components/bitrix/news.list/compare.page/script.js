$(document).on('change', '.js-checkbox-filter', (e) => {
	$.ajax({
		url: location.href,
		data: {'different': e.target.checked ? 'Y' : 'N'},
		dataType: 'html',
		success: function (data) {
			$('.js-compare-table').html($(data).find('.js-compare-table').html())
		}
	});

})
