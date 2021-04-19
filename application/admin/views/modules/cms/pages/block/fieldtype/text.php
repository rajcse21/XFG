<?php 
$val='';
if(isset($field_value) && $field_value!=''){
	$val=$field_value;
}
?>
<input type="text" class="form-control" name="<?php echo $field_alias ?>" id="<?php echo $field_alias ?>" value="<?php echo set_value($field_alias, $val); ?>" />