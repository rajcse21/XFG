<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Userauth {

	private $member_data;
	private $login_flag = FALSE;

	function __construct() {
		log_message('debug', "Userauth Class Initialized");

		$this->login_flag = $this->validSession();
	}

	private function validSession() {
		$CI = & get_instance();
		$userid = $CI->session->userdata('ADMIN_ID');

		if (isset($userid) && (trim($userid) != '') && is_numeric($userid)) {
			$CI->load->model('Usermodel');
			$user = $CI->Usermodel->fetchByID($userid);
			if ($user) {
				$this->member_data = $user;
				return TRUE;
			}
			$CI->session->sess_destroy();
		}

		return FALSE;
	}

	function checkAuth() {
		if ($this->login_flag) {
			return $this->member_data;
		}

		return false;
	}

	public function checkResourceAccess($resource) {
		if (!$this->checkAuth())
			return FALSE;

		if ($this->member_data['superuser'] == 1) {
			return true;
		}

		if ($this->member_data['admin_role_id'] == 1) {
			return true;
		}

		if (in_array($resource, $this->user_permissions)) {
			return TRUE;
		}

		return FALSE;
	}

	public function checkAccess($resource) {

		if (!$this->checkAuth())
			return FALSE;

		if ($this->member_data['admin_role_id'] == 1)
			return true;

		if (in_array($resource, $this->user_permissions))
			return TRUE;

		return TRUE;
	}

	function getUser() {
		return $this->member_data;
	}

	function isAdmin() {
		return ($this->user_type == 'ADMIN');
	}

	function getUserName() {
		return $this->user_name;
	}

}