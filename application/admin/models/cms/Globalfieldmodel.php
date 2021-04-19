<?php

class Globalfieldmodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function listByBlockId($block_id) {
		$this->db->where('global_block_id', intval($block_id));
		$rs = $this->db->get('globalblock_field');
		if ($rs && $rs->num_rows() > 0) {
			return $rs->result_array();
		}
		return FALSE;
	}

	function fetchById($globalblock_field_id) {
		$this->db->where('globalblock_field_id', $globalblock_field_id);
		$rs = $this->db->get('globalblock_field');
		if ($rs && $rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return FALSE;
	}

	function insertRecord($global_block_id) {
		
		$data = array();

		$data['global_block_id'] = $global_block_id;
		$data['field_type'] = $this->input->post('field_type', TRUE);
		$data['field_alias'] = strtolower(url_title($this->input->post('field_alias', TRUE)));
		$data['field_label'] = $this->input->post('field_label', TRUE);
		$data['field_options'] = $this->input->post('field_options', TRUE);
	
		$this->db->insert('globalblock_field', $data);
	}

	function updateRecord($globalblock_field_id) {
		$data = array();

		$data['field_type'] = $this->input->post('field_type', TRUE);
		$data['field_alias'] = strtolower(url_title($this->input->post('field_alias', TRUE)));
		$data['field_label'] = $this->input->post('field_label', TRUE);
		$data['field_options'] = $this->input->post('field_options', TRUE);
		
		$this->db->where('globalblock_field_id', $globalblock_field_id);
		$this->db->update('globalblock_field', $data);
	}

	function delete($globalblock_field_id) {
		$this->db->where('globalblock_field_id', $globalblock_field_id);
		$this->db->delete('globalblock_field');
	}

}

?>