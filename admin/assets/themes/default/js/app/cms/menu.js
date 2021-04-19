jQuery(document).ready(function($) {
	function postData(data) {
		$("#dialog-modal").dialog({
			height: 140,
			modal: true
		});

		$.post('cms/ajax/menuitem/updateSortOrder', data, function(data) {
			$("#dialog-modal").dialog('close');
		});
	}

	var options = {
		containment: 'parent',
		opacity: 0.6,
		update: function(event, ui) {
			var data = $(this).sortable('serialize');
			data = data + '&' + $('#csrf_token').val() + "=" + $('#csrf_hash').val();
			postData(data);
		}
	};

	$("#sortable").sortable(options);
	$("#sortable ul").sortable(options);
	$("#sortable ul ul").sortable(options);
});