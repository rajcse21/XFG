<?php

class Includemodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function listAll() {
		$rs = $this->db->get('page');

		return $rs->result_array();
	}

	function fetchAllModules($page_id) {
		$this->db->where('page_id', intval($page_id));
		$rs = $this->db->get('page_include');
		return $rs->result_array();
	}

	function getGlobalModules($location) {
		$this->db->where('include_location', $location);
		$this->db->where('include_scope', 'global');
		$this->db->where('is_include_active', '1');
		$rs = $this->db->get('include');
		return $rs->result_array();
	}

	function getModules($include_id, $location) {
		if (!$include_id) {
			return FALSE;
		}
		$this->db->where('include_location', $location);
		$this->db->where('is_include_active', '1');
		$this->db->where_in('include_id', $include_id);
		$rs = $this->db->get('include');
		return $rs->result_array();
	}

}

?>
