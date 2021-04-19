<div class="panel panel-default">
	<div class="panel-body">
		<div class="fm_image_picker">
			<div class="fm_image">
				<div class="row">
					<div class="col-md-8">
						<a href="<?php echo $file; ?>" class="fm_img_link" target="_blank" style="<?php echo ($file) ? '' : 'display: none'; ?>">
							File Link
						</a>
					</div>
					<div class="col-md-4">
						<div class="row">
							<div class="col-md-12"><a href="javascript:void(0);" class="img-remove-trigger btn  btn-default btn-xs btn-block" style="margin-bottom: 5px; <?php echo ($file) ? '' : 'display: none'; ?>" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Remove</a></div>
							<div class="col-md-12"><a href="<?php echo $this->config->item('FILEMANAGER_FILE_PATH'); ?>&field_id=image_link_<?php echo $name; ?>" class="upload_img fancybox.iframe btn  btn-default btn-xs btn-block" ><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Browse</a></div>
						</div>
					</div>
				</div>
			</div>
			<input id="image_link_<?php echo $name; ?>" name="<?php echo $name; ?>" class="fm_image_input" type="hidden" value="<?php echo isset($file) ? $file : ''; ?>">
		</div>
	</div>
</div>