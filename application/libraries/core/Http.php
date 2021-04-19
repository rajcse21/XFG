<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Http {

	private $CI;

	function __construct() {
		log_message('debug', "HTTP Class Initialized");

		$this->CI = & get_instance();
	}

	function isSSL() {
		if (isset($_SERVER['HTTPS'])) {
			if ('on' == strtolower($_SERVER['HTTPS'])) {
				return true;
			}

			if ('1' == $_SERVER['HTTPS']) {
				return true;
			}
		} elseif (isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] )) {
			return true;
		}
		return false;
	}

	function baseURL() {
		$url = base_url();
		if ($this->isSSL()) {
			return str_replace('http://', 'https://', $url);
		}

		return $url;
	}

	function baseHost() {
		$url = $_SERVER['HTTP_HOST'];
		if ($this->isSSL()) {
			return "https://$url/";
		}

		return "http://$url/";
	}

	function baseURLNoSSL() {
		$url = $this->baseURL();
		return str_replace('https://', 'http://', $url);
	}

	function baseURLSSL() {
		$url = $this->baseURL();
		return str_replace('http://', 'https://', $url);
	}

	function themeURL() {
		$url = $this->baseURL();

		return $url . "assets/themes/" . THEME . "/";
	}

	function show404($message = 'Page Not Found') {

		$page_arr = $this->CI->cmscore->loadPage('404');
		if (!$page_arr) {
			show_404($message);
			return;
		}
		$this->CI->cmscore->renderPage($page_arr);
	}

	function getIP() {
		$ip = false;
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	function jsonOutput($data) {
		$this->CI->output
				->set_content_type('application/json')
				->set_output(json_encode($data, JSON_PRETTY_PRINT))
				->_display();
		exit();
	}

}
