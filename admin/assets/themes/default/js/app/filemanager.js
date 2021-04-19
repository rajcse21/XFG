jQuery(document).ready(function ($) {
	$(".browse_files").click(function (e) {
		e.preventDefault();
		var $link = $(this);
		$.fancybox.open({
			type: 'iframe',
			src: $link.attr('href')
		});
	});

	$(".upload_img").click(function (e) {

		e.preventDefault();

		var $link = $(this);
		var $parent = $link.parents('.fm_image_picker');
		var $fm_img_tag = $parent.find('.fm_img_tag');
		var $fm_img_link = $parent.find('.fm_img_link');
		var $fm_image_input = $parent.find('.fm_image_input');
		var $img_remove_trigger = $parent.find('.img-remove-trigger');


		$.fancybox.open({
			type: 'iframe',
			src: $link.attr('href'),
			afterClose: function () {
				var img_link = $fm_image_input.val();

				if (img_link != 'undefined' && img_link != '') {
					$fm_img_tag.attr('src', img_link);
					$fm_img_link.attr('href', img_link);
					$img_remove_trigger.show();
					$fm_img_link.show();
				}
			}
		});
	});


	$('.file_browse').click(function () {
		$('.filemanager_field').val();
		parent.$('.filemanager_field').attr('value', $(this).attr('href'));
		fm_field();
		parent.$.fancybox.close();

	});

	$('.img-remove-trigger').on('click', function () {
		//$(this).parent().parent().find('.fm_image_input').removeAttr('value');
		$(this).parents('.fm_image_picker').find('.fm_image_input').removeAttr('value');
		//$(this).closest('.fm_image').hide();
		$(this).parents('.fm_image_picker').find('.fm_img_link').hide();
	});

	function fm_field()
	{
		var fm_field = $('.file_image').attr('href');
		fm_field = parent.$('.filemanager_field').val();
		if (fm_field != '')
		{
			parent.$('.fm_image').html('<a href="' + fm_field + '" class="file_image" target="_blank">Image Link</a>');
		} else
		{
			parent.$('.fm_image').html('');
		}
	}

});