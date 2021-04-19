<?php 
$val='';
if(isset($field_value) && $field_value!=''){
	$val=$field_value;
}
echo $this->filemanager->render($field_alias, $val); ?>