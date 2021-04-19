<div class="container-fluid my-5">
	<div class="row">
		<div class="col-md-3">&nbsp;</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">Retrieve Password</div>

				<div class="card-body">
					<p>Input your Username in the box below and we will send your password .</p>
					<?php $this->load->view('inc-messages'); ?>
					<?php echo form_open('user/lostpasswd', array("autocomplete" => "off", "method" => "POST", "class" => "")); ?>
					<div class="form-group">
						<label for="username">Username *</label>
						<input name="username" type="username" class="form-control <?php echo (form_error('username')) ? "is-invalid" : ""; ?>" id="username" value="<?php echo set_value('username') ?>" placeholder="Username" required />
						<?php echo form_error('username'); ?>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
					<?php echo form_close(); ?>
				</div>
				<div class="card-footer text-right">
					<div class="form-group">
						<p>Fields marked with <span class="required">*</span> are required.</p>
					</div>
				</div>
			</div>
		</div><div class="col-md-3">&nbsp;</div>
	</div>
</div>