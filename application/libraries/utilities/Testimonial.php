<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Testimonial {

	function __construct() {
		log_message('debug', "Avatar Class Initialized");
	}

	function getAll($email) {
            $this->load->model('cms/pagemodel');
		return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=mm&r=pg&s=35";
	}

}
