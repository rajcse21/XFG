<?php
$val='';
if(isset($field_value) && $field_value!=''){
	$val=$field_value;
}
$field_options = explode(';', $field_options);
$options = array();
if ($field_options) {
	foreach ($field_options as $row) {
		$row = explode(':', $row);
		$label = '';
		$value = '';
		if(isset($row[0])){
			$label = $row[0];
		}
		if(isset($row[1])){
			$value = $row[1];
		}
		$options[$value] = $label;
	}
}

echo form_dropdown($field_alias, $options, set_value($field_alias,$val), ' id="' . $field_alias . '" class="form-control"');
?>