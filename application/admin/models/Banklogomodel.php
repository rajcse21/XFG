<?php

class Banklogomodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	//fetch by ID
	function fetchByID($bid) {
		$this->db->from('bank_logo');
		$this->db->where('bank_logo_id', intval($bid));
		$rs = $this->db->get();
		if ($rs && $rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return false;
	}
        
	function countAll() {
		$this->db->from('bank_logo');
		return $this->db->count_all_results();
	}

	function listAll($offset = FALSE, $limit = FALSE) {
		if ($offset)
			$this->db->offset($offset);
		if ($limit)
			$this->db->limit($limit);

		$this->db->order_by('bank_logo_sort_order', 'ASC');
		$rs = $this->db->get('bank_logo');
		return $rs->result_array();
	}
        
	function getOrder() {
		$this->db->select_max('bank_logo_sort_order');
		$query = $this->db->get('bank_logo');
		$sort_order = $query->row_array();
		return $sort_order['bank_logo_sort_order'] + 1;
	}



}
