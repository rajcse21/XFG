<?php

class Usermodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function fetchByEmail($email) {
		$this->db->from('admin_user');
		//$this->db->where('email', strtolower(trim($email))), FILTER_SANITIZE_EMAIL);
		$this->db->where('email', $email);
		$rs = $this->db->get();
		if ($rs && $rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return false;
	}

	//fetch by ID
	function fetchByID($cid) {
		$this->db->from('admin_user');
		$this->db->where('admin_user_id', intval($cid));
		$rs = $this->db->get();
		if ($rs && $rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return false;
	}


}
