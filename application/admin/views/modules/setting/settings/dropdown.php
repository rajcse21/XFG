<?php if ($field_options) { ?>
	<?php $fieldvalue = explode('|', $field_options); ?>
	<select name="<?php echo $key; ?>" class="form-control">
		<option value="">--Select--</option>
		<?php foreach ($fieldvalue as $field) { ?>
			<?php
			$field_arr = explode(':', $field);
			$select = '';
			if ($val == $field_arr[1]) {
				$select = 'selected="selected"';
			}
			?>
			<option value="<?php echo $field_arr[1]; ?>" <?php echo $select; ?>><?php echo $field_arr[0]; ?></option>
		<?php } ?>
	</select>
<?php } ?>
