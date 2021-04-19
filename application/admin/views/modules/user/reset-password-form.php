<div class="container-fluid my-5">
	<h1>Set Password</h1>
	<div class="panel-body">
		<?php echo form_open("user/reset_password/$reset_passwd_key"); ?>

	
		<div class="form-group">
			<label for="password_real">Password</label>
			<input name="password_real" id="password_real" type="password" class="form-control <?php echo (form_error('password_real')) ? "is-invalid" : ""; ?>" placeholder="Password" autocomplete="off" />
		<?php echo form_error('password_real'); ?>
		</div>
		<div class="form-group">
			<label for="confirm_password_real">Confirm Password</label>
			<input name="confirm_password_real" id="confirm_password_real" type="password" class="form-control <?php echo (form_error('confirm_password_real')) ? "is-invalid" : ""; ?>" placeholder="Confirm Password" autocomplete="off" />
		<?php echo form_error('confirm_password_real'); ?>
		</div>
		<div class="form-group">
			<input type="hidden" name="user_id" id="user_id" value="<?php echo $user['admin_user_id']; ?>">
		</div>
		<div class="form-group">
			<button class="btn btn-default" type="submit">Submit</button>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>	