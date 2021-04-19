<div class="card">
	<div class="card-body">
		<div class="fm_image_picker">
			<div class="fm_image">
				<div class="row">
					<div class="col-md-8">
						<a href="<?php echo $image; ?>" class="fm_img_link" target="_blank" style="<?php echo ($image) ? '' : 'display: none'; ?>">
							<img src="<?php echo $image; ?>" class="fm_img_tag" style="max-width:100%; heigh: auto; max-height: 80px;" />
						</a>
					</div>
					<div class="col-md-4">
						<div class="row">
							<div class="col-md-12"><a href="javascript:void(0);" class="img-remove-trigger btn btn-secondary btn-xs btn-block" style="margin-bottom: 5px; <?php echo ($image) ? '' : 'display: none'; ?>" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Remove</a></div>
							<div class="col-md-12"><a href="<?php echo $this->config->item('FILEMANAGER_PATH'); ?>&field_id=image_link_<?php echo $name; ?>" class="upload_img fancybox.iframe btn btn-secondary btn-xs btn-block" ><i class="fas fa-arrow-circle-down"></i> Browse</a></div>
						</div>
					</div>
				</div>

			</div>
			<input id="image_link_<?php echo $name; ?>" name="<?php echo $name; ?>" class="fm_image_input" type="hidden" value="<?php echo isset($image) ? $image : ''; ?>">
		</div>
	</div>
</div>
<?php if (form_error($name)) { ?>
	<div class="form-group">
		<div class="form-control <?php echo (form_error($name)) ? "is-invalid" : ""; ?>">
			<?php echo form_error($name); ?>
		</div>
	</div>
<?php } ?>
