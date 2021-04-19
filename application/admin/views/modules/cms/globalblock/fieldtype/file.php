<?php 
$val='';
if(isset($field_value) && $field_value!=''){
	$val=$field_value;
}
echo $this->filemanager->renderFile($field_alias, $val); ?>