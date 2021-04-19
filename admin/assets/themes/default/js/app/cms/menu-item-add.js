jQuery(document).ready(function($) {
	$('.div-hide').hide();

	function initForm(val) {
		$('.div-hide').hide();
		$("."+val).show();
	}

	$('#menu_item_type').change(function() {
		initForm($(this).val());
	});

	initForm($('#menu_item_type').val());
});