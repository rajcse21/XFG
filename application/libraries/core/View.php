<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class View {

	private $CI;

	function __construct() {
		log_message('debug', "View Class Initialized");
		$this->CI = & get_instance();
	}

	function load($view, $params = array()) {
		if (file_exists(APPPATH . "views/themes/" . THEME . "/modules/" . ltrim($view, '/'))) {
			return $this->CI->load->view("themes/" . THEME . "/modules/" . ltrim($view, '/'), $params, true);
		} else {
			return $this->CI->load->view("modules/" . ltrim($view, '/'), $params, true);
		}
	}

}
