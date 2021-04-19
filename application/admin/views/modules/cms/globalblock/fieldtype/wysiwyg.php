<?php
$val='';
if(isset($field_value) && $field_value!=''){
	$val=$field_value;
}
?>
<textarea class="form-control wysiwyg" rows="5" name="<?php echo $field_alias ?>" id="<?php echo $field_alias ?>"><?php echo set_value($field_alias, $val); ?></textarea>