jQuery(document).ready(function ($) {

	/* Bootstrap Tab URL Hash Target */
	$(function () {
		var hash = window.location.hash;
		hash && $('ul.nav a[href="' + hash + '"]').tab('show');
		$('.nav-tabs a').click(function (e) {
			$(this).tab('show');
			var scrollmem = $('body').scrollTop();
			window.location.hash = this.hash;
			$('html,body').scrollTop(scrollmem);
		});
	});

	//page section close
	if ($('.page_section_success').length != 0) {
		parent.location.reload();
		parent.$.fancybox.close();
	}

	//Add -/+ Links for Sections
	$('.collapse').on('shown.bs.collapse', function (e) {

		var section_id = $(this).data('id');

		$('#section-' + section_id + ' .section_panel_icons').removeClass('fa fa-plus');
		$('#section-' + section_id + ' .section_panel_icons').addClass('fa fa-minus');
	});
	$('.collapse').on('hidden.bs.collapse', function (e) {
		var section_id = $(this).data('id');
		$('#section-' + section_id + ' .section_panel_icons').addClass('fa fa-plus');
		$('#section-' + section_id + ' .section_panel_icons').removeClass('fa fa-minus');
	});

	$('.fancybox').click(function () {
		var link = $(this).data('link');
		$.fancybox.open({
			type: 'iframe',
			src: link,
			autoSize: false,
			fitToView: true,
			afterClose: function () {
				//loadSections();
			},
			iframe: {
				css: {					
					height: "600px"
				}
			}
		});
		
	});

	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href")		// activated tab
	});

	//Sortable Sections
	$("#page_content_wrapper .page_sections").sortable({
		items: "> .section",
		containment: 'parent',
		//placeholder: "col-sm-12 ui-state-highlight card bg-light",
		opacity: 0.6,
		distance: 5,
		update: function (event, ui) {
			var data = $(this).sortable('serialize');
			$.post('cms/ajax/section/updateSortOrder', data, function (data) {

			});
		}
	});
	//Sortable Blocks
	$("#page_content_wrapper .page-blocks").sortable({
		items: "> .page-block",
		placeholder: "col-sm-6 ui-state-highlight card bg-light",
		update: function (event, ui) {
			var data = $(this).sortable('serialize');
			$.post('cms/ajax/block/updateSortOrder', data, function (data) {
			});
		}
	});

	$("#page_content_wrapper").on('click', '.duplicate_block_cls', function (e) {
		var page_block_id = $(this).data('page_block_id');
		$(this).block({
			message: '',
			overlayCSS: {
				padding: 0,
				margin: 0,
				textAlign: 'center',
				backgroundColor: '#000',
				color: '#000',
				opacity: 0.7
			},
			css: {
				border: '0px',
				//width: '0%',
				backgroundColor: 'transparent',
				width: '100%',
				left: '0px'
			}
		});
		$.post("cms/block/duplicate_block/" + page_block_id, function (data) {
			if (data.status == 1) {
				$(this).unblock();
				location.reload();
			}
		}, 'json');
	});
//Change Columns layout
	$("body").on('change', '.column-trigger', function (e) {
		var $column_val = $(this).val();
		if ($column_val <= 12) {
			$column_padding = 12 - $column_val;

			$(this).closest('.row').find('.column-padding').empty();
			$(this).closest('.row').find('.column-padding').fadeOut('fast'); // to look good
			$(this).closest('.row').find('.column-padding').fadeIn('fast');		// to look good
			for (var $i = 0; $i <= $column_padding; $i++) {
				$($(this).closest('.row').find('.column-padding')).append($('<option>', {
					value: $i,
					text: $i
				}));
			}
		}
	});


	if ($('.field_type').length) {
		$('.field_type').change(function () {
			var value = $(this).val();
			change_field(value);
		});
		change_field($('.field_type').val());
	}

	function change_field(value) {
		if (value == '') {
			$('.field_options').hide();
			return;
		}
		if (value == 'dropdown') {
			$('.field_options').show();
		} else {
			$('.field_options').hide();
		}

	}


});
