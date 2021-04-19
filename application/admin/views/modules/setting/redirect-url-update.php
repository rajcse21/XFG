<div id="content_main">
	<h1>Redirect URLs</h1>
	<?php $this->load->view('inc-messages'); ?>

	<?php echo form_open("setting/redirect_url/"); ?>
	<div class="form-group">
		<textarea class="form-control" name="redirect_url" id="redirect_url" rows="20" ><?php echo set_value('redirect_url', $rewrite_str); ?></textarea>
	</div>
	<div class="form-group">
		<h5>Fields marked with <span class="required">*</span> are required.</h5>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>

	<?php echo form_close(); ?>
</div>