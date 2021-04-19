<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Ajax {

	private $CI;
	private $wrapper = [
		'status' => 0,
		'code' => '',
		'message' => '',
		'payload' => ''
	];

	function __construct() {
		log_message('debug', "Ajax Class Initialized");
		$this->CI = & get_instance();
	}

	function error($params = []) {
		$this->wrapper['status'] = 0;
		foreach ($params as $key => $val) {
			$this->wrapper[$key] = $val;
		}
		$this->CI->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($this->wrapper, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
				->_display();
		exit();
	}

	function success($params = []) {
		$this->wrapper['status'] = 1;
		foreach ($params as $key => $val) {
			$this->wrapper[$key] = $val;
		}
		$this->CI->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($this->wrapper, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
				->_display();
		exit();
	}
	
	function getWrapper() {
		return $this->wrapper;
	}

}
