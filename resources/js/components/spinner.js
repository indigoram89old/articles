$(function () {
	$('[data-form-spinner]').on('submit', function () {
		$($(this).data('form-spinner')).addClass('active');
	});
});