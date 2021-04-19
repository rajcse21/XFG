<div id="popup_container">
 	<?php $this->load->view('inc-messages'); ?>
	<?php echo form_open("cms/block/block_type/{$section['page_section_id']}/{$global_block_id}"); ?>
	
	<div class="form-group block_type">
		<label for="block_type" class="control-label" >Block Type<span class="required">*</span></label>
		<?php echo form_dropdown('block_type', $block_types, set_value('block_type'), ' id="block_type" class="form-control"'); ?>
	</div>

	<div class="form-group">
		<h5>Fields marked with <span class="required">*</span> are required.</h5>
	</div>
	<div class="form-group">
		<input type="hidden" name="global_block" class="is_global_block" value="<?php echo !$section ? 1:0;?>"/>
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
	<?php echo form_close(); ?>
</div>
