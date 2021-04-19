<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Filemanager {

	function __construct() {
		$CI = & get_instance();
	}

	function render($name, $image = false, $params = array()) {
		$CI = & get_instance();
		$inner = array();

		$inner['name'] = $name;
		$inner['image'] = $image;
		$inner['params'] = $params;
		return $CI->view->load('filemanager/image', $inner, true);
	}

	function renderFile($name, $file = false) {
		$CI = & get_instance();
		$inner = array();

		$inner['name'] = $name;
		$inner['file'] = $file;
		return $CI->view->load('filemanager/file', $inner, true);
	}

}

?>