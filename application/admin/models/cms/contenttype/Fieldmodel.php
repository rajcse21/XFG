<?php

class Fieldmodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	//Get template details
	function detail($ct_fid) {
		$this->db->select('*');
		$this->db->from('content_field');
		$this->db->join('content_type', 'content_type.content_type_id = content_field.content_type_id');
		$this->db->where('content_field_id', intval($ct_fid));
		$rs = $this->db->get();
		if ($rs->num_rows() == 1)
			return $rs->row_array();

		return FALSE;
	}

	//List All templates
	function listAll($ctid, $offset = FALSE, $limit = FALSE) {
		if ($offset)
			$this->db->offset($offset);
		if ($limit)
			$this->db->limit($limit);
		$this->db->from('content_field');
		$this->db->join('content_fieldgroup', 'content_fieldgroup.content_fieldgroup_id = content_field.content_fieldgroup_id', 'left');
		$this->db->where('content_field.content_type_id', intval($ctid));
		$rs = $this->db->get();
		return $rs->result_array();
	}

	//List All templates
	function listGroupFields($ctid, $gid) {
		$this->db->from('content_field');
		$this->db->join('content_fieldgroup', 'content_fieldgroup.content_fieldgroup_id = content_field.content_fieldgroup_id', 'left');
		$this->db->join('field_type', 'field_type.field_type_id = content_field.field_type_id', 'left');
		$this->db->where('content_field.content_type_id', intval($ctid));
		$this->db->where('content_field.content_fieldgroup_id', intval($gid));
		$rs = $this->db->get();
		return $rs->result_array();
	}

	//Function count all templates
	function countAll($ctid) {
		$this->db->from('content_field');
		$this->db->where('content_type_id', intval($ctid));
		return $this->db->count_all_results();
	}

	//Function insert record
	function insertRecord($content_type) {
		$data = array();
		$data['content_type_id'] = $content_type['content_type_id'];
		$data['content_fieldgroup_id'] = $this->input->post('content_fieldgroup_id', TRUE);
		$data['field_type_id'] = $this->input->post('field_type', TRUE);
		$data['field_value'] = $this->input->post('vocabulary', TRUE);
		$data['field_label'] = $this->input->post('field_label', TRUE);
		$data['field_alias'] = strtolower(url_title($this->input->post('field_alias', TRUE)));
		$data['field_help'] = '';


		$this->db->insert('content_field', $data);
	}

	//Function update record
	function updateRecord($content_field) {
		$data = array();
		$data['content_type_id'] = $content_field['content_type_id'];
		$data['content_fieldgroup_id'] = $this->input->post('content_fieldgroup_id', TRUE);
		$data['field_type_id'] = $this->input->post('field_type', TRUE);
		$data['field_value'] = $this->input->post('vocabulary', TRUE);
		$data['field_label'] = $this->input->post('field_label', TRUE);
		$data['field_alias'] = strtolower(url_title($this->input->post('field_alias', TRUE)));
		$data['field_help'] = '';

		$this->db->where('content_field_id', $content_field['content_field_id']);
		$this->db->update('content_field', $data);
	}

	//Function delete records
	function deleteRecord($ct_field) {
		$this->db->where('content_field_id', $ct_field['content_field_id']);
		$this->db->delete('content_field');
	}

}

?>
