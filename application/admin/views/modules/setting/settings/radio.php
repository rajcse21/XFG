<?php

if ($field_options) { ?>
	<?php $fieldvalue = explode('|', $field_options); ?>
<br />
	<?php foreach ($fieldvalue as $field) { ?>
		<?php $field_arr = explode(':', $field); ?>
	<label class="radio-inline"><input type="radio" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $field_arr[1]; ?>"  <?php echo set_radio("$key", $field_arr[1], ($val == $field_arr[1])); ?> /><?php echo $field_arr[0]; ?></label>
	<?php } ?>
<?php } else { ?>
<label class="radio-inline"><input type="radio" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="1"  <?php echo set_radio("$key", "1", ($val == "1")); ?> />Yes</label>
<label class="radio-inline"><input type="radio" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="0"  <?php echo set_radio("$key", "0", ($val == "0")); ?> />No</label>
<?php } ?>