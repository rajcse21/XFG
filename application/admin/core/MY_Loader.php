<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {
	
	function __construct() {
		parent::__construct();
		$main_basepath = realpath(BASEPATH."../application".DIRECTORY_SEPARATOR);
		$this->_ci_library_paths =	array(APPPATH, BASEPATH, $main_basepath.DIRECTORY_SEPARATOR);
	}

}