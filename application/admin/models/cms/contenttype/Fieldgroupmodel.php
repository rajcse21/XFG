<?php

class Fieldgroupmodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	//function to get sort order
	function getSortOrder($ctid) {
		$this->db->select_max('content_fieldgroup_sort_order');
		$this->db->where('content_type_id', intval($ctid));
		$query = $this->db->get('content_fieldgroup');
		$sort_order = $query->row_array();
		return $sort_order['content_fieldgroup_sort_order'] + 1;
	}
	
	//Get template details
	function detail($ct_gid) {;
		$this->db->from('content_fieldgroup');
		$this->db->join('content_type', 'content_type.content_type_id = content_fieldgroup.content_type_id');
		$this->db->where('content_fieldgroup_id', intval($ct_gid));
		$rs = $this->db->get();
		if ($rs->num_rows() == 1)
			return $rs->row_array();

		return FALSE;
	}
	
	//Function count all page type field group
	function countAll($ctid) {
		$this->db->from('content_fieldgroup');
		$this->db->where('content_type_id', intval($ctid));
		return $this->db->count_all_results();
	}

	//List All content type field group
	function listAll($ctid, $offset = FALSE, $limit = FALSE) {
		
		if ($offset)
			$this->db->offset($offset);
		if ($limit)
			$this->db->limit($limit);

		$this->db->where('content_type_id', intval($ctid));
		$this->db->order_by('content_fieldgroup_sort_order', 'ASC');
		$rs = $this->db->get('content_fieldgroup');
		
		return $rs->result_array();
	}

	
	//Function insert record
	function insertRecord($content_type) {
		$data = array();
		$data['content_type_id'] = $content_type['content_type_id'];
		$data['content_fieldgroup'] = $this->input->post('fieldgroup', TRUE);
		$data['content_fieldgroup_sort_order'] = $this->getSortOrder($content_type['content_type_id']);
	
		$this->db->insert('content_fieldgroup', $data);
	}

	//Function update record
	function updateRecord($ct_fieldgroup) {
		$data = array();
		$data['content_fieldgroup'] = $this->input->post('fieldgroup', TRUE);

		$this->db->where('content_fieldgroup_id', $ct_fieldgroup['content_fieldgroup_id']);
		$this->db->update('content_fieldgroup', $data);
	}

	//Function delete records
	function deleteRecord($ct_fieldgroup) {
		$this->db->where('content_fieldgroup_id', $ct_fieldgroup['content_fieldgroup_id']);
		$this->db->delete('content_fieldgroup');
	}

}

?>
