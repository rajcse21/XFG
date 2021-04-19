<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Html {

	private $CI;
	private $before_head_close = array();
	private $after_body_open = array();
	private $before_body_close = array();
	private $body_class = '';
	private $global_blocks = array();

	function __construct() {
		log_message('debug', "HTML Class Initialized");
		$this->CI = & get_instance();
	}

	function menu($params) {
		$CI = & get_instance();
		$CI->load->model('cms/Menumodel');
		return $CI->Menumodel->menu($params);
	}

	function parentmenu($params) {
		$CI = & get_instance();
		$CI->load->model('cms/Menumodel');
		return $CI->Menumodel->parentmenu($params);
	}

	function setBodyClass($class) {
		$this->body_class .= " " . $class;
	}

	function getBodyClass() {
		return $this->body_class;
	}

	function renderBeforeHeadClose() {
		$css_am = new Assetic\AssetManager();
		$css_am->set("min", $this->CI->CSS);

		$writer = new Assetic\AssetWriter(FCPATH . ASSETS_PATH . '/css/');
		$writer->writeManagerAssets($css_am);

		return '<link crossorigin="anonymous" href="' . $this->CI->http->baseURL() . ASSETS_PATH . '/css/min-styles.css" media="all" rel="stylesheet" />';
	}

	//render before Body close
	function renderBeforeBodyClose() {
		$am = new Assetic\AssetManager();
		$am->set("min", $this->CI->JS);

		$writer = new Assetic\AssetWriter(FCPATH . ASSETS_PATH . '/js/');
		$writer->writeManagerAssets($am);

		return '<script crossorigin="anonymous" src="' . $this->CI->http->baseURL() . ASSETS_PATH . '/js/min-scripts.js"></script>';
	}

	public function loadView($view, $vars = array(), $return = FALSE) {
		return $this->CI->load->view("themes/" . THEME . "/$view", $vars, $return);
	}

}
