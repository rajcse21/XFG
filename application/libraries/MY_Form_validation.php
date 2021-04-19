<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	public function is_string($str) {
		if (is_array($str)) {
			return FALSE;
		}

		return true;
	}

	public function zip5($str) {
		if (is_array($str)) {
			$this->CI->form_validation->set_message('zip5', 'Invalid ZIP code. Please enter a valid ZIP code.');
			return FALSE;
		}

		if (!$this->CI->zipcode->uspsLookup($str)) {
			$this->CI->form_validation->set_message('zip5', 'Invalid ZIP code. Please enter a valid ZIP code.');
			return FALSE;
		}

		return true;
	}

	public function date_dmy($str) {
		if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/", $str)) {
			return true;
		} else {
			return false;
		}
	}

	public function date_ymd($str) {
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $str)) {
			return true;
		} else {
			return false;
		}
	}

	public function clean_ymd($str) {
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $str)) {
			return $str;
		}
		return '';
	}

	public function clean_dmy($str) {
		if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/", $str)) {
			return $str;
		}
		return '';
	}

	public function string_common($str) {
		return (!preg_match("/^([a-z0-9 _-])+$/i", $str)) ? FALSE : TRUE;
	}

	public function string_rel_url($str) {
		return (!preg_match("/^([a-z0-9\/_-])+$/i", $str)) ? FALSE : TRUE;
	}

	public function clean_string($str) {
		$str = filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		$str = preg_replace("/[^a-z0-9_ -]/i", '', $str);
		return $str;
	}

	public function clean_rel_url($str) {
		$str = filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		$str = preg_replace("/[^a-z0-9\/_-]/i", '', $str);
		return $str;
	}

	public function clean_email($str) {
		return filter_var($str, FILTER_SANITIZE_EMAIL);
	}

	public function clean_url($str) {
		return filter_var($str, FILTER_SANITIZE_URL);
	}


}
