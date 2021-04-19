<?php

class Globalsectionmodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function fetchById($sid) {
		$this->db->where('global_section_id', intval($sid));
		$rs = $this->db->get('global_section');
		if ($rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return FALSE;
	}

	function countAll($filter = false) {
		$this->db->join('global_category', 'global_category.global_category_id=global_section.global_category_id', 'LEFT');
		if (isset($filter['category']) && $filter['category'] != '') {
			$this->db->where('global_section.global_category_id', $filter['category']);
		}
		$this->db->from('global_section');
		return $this->db->count_all_results();
	}

	function listAll($offset = FALSE, $limit = FALSE, $filter = false) {
		if ($offset)
			$this->db->offset($offset);
		if ($limit)
			$this->db->limit($limit);

		$this->db->join('global_category', 'global_category.global_category_id=global_section.global_category_id', 'LEFT');
		if (isset($filter['category']) && $filter['category'] != '') {
			$this->db->where('global_section.global_category_id', $filter['category']);
		}
		$this->db->order_by('section_sort_order', 'ASC');
		$rs = $this->db->get('global_section');
		if ($rs && $rs->num_rows() > 0) {
			return $rs->result_array();
		}
		return array();
	}

	function getOrder() {
		$this->db->select_max('section_sort_order');
		$query = $this->db->get('global_section');
		$sort_order = $query->row_array();
		return $sort_order['section_sort_order'] + 1;
	}

	function insert() {
		$data = array();

		$data['section_name'] = $this->input->post('section_name', TRUE);

		if ($this->input->post('section_alias', TRUE)) {
			$data['section_alias'] = url_title(strtolower($this->input->post('section_alias', TRUE)));
		}

		$data['section_background'] = $this->input->post('section_background', TRUE);
		$data['section_img_medium'] = $this->input->post('section_img_medium', TRUE);
		$data['section_img_small'] = $this->input->post('section_img_small', TRUE);
		$data['section_template'] = $this->input->post('section_template', FALSE);
		$data['section_block_template'] = $this->input->post('section_block_template', FALSE);
		$data['section_desc'] = '';
		if ($this->input->post('section_desc', FALSE)) {
			$data['section_desc'] = $this->input->post('section_desc', FALSE);
		}
		$data['section_icon'] = '';
		if ($this->input->post('section_icon', TRUE)) {
			$data['section_icon'] = $this->input->post('section_icon', TRUE);
		}
		if ($this->input->post('section_category', TRUE)) {
			$data['global_category_id'] = $this->input->post('section_category', TRUE);
		} else {
			$data['global_category_id'] = 0;
		}
		$data['section_sort_order'] = $this->getOrder();
		$data['section_is_active'] = 1;

		$this->db->insert('global_section', $data);
	}

	function update($section_id) {
		
		$data = array();

		$data['section_name'] = $this->input->post('section_name', TRUE);
		$data['section_alias'] = url_title(strtolower($this->input->post('section_alias', TRUE)));
		$data['section_background'] = $this->input->post('section_background', TRUE);
		$data['section_img_medium'] = $this->input->post('section_img_medium', TRUE);
		$data['section_img_small'] = $this->input->post('section_img_small', TRUE);
		if ($this->input->post('section_category', TRUE)) {
			$data['global_category_id'] = $this->input->post('section_category', TRUE);
		} else {
			$data['global_category_id'] = 0;
		}
		$data['section_template'] = $this->input->post('section_template', FALSE);
		$data['section_block_template'] = $this->input->post('section_block_template', FALSE);
		if ($this->input->post('section_desc', FALSE)) {
			$data['section_desc'] = $this->input->post('section_desc', FALSE);
		}
		$data['section_icon'] = '';
		if ($this->input->post('section_icon', TRUE)) {
			$data['section_icon'] = $this->input->post('section_icon', TRUE);
		}
		$data['section_updated_on'] = time();

		$this->db->where('global_section_id', $section_id);
		$this->db->update('global_section', $data);
	}

	function delete($section_id) {
		//Delete Blocks Additional Field
		$global_blocks = $this->Globalblockmodel->listAll($section_id);
		foreach ($global_blocks as $block) {
			$this->db->where('global_block_id', $block['global_block_id']);
			$this->db->delete('globalblock_field');
		}
		//Delete Global Block 
		$this->db->where('global_section_id', $section_id);
		$this->db->delete('global_block');

		$this->db->where('global_section_id', $section_id);
		$this->db->delete('global_section');
	}

	function enable($section_id) {
		$data = array();
		$data['section_is_active'] = 1;

		$this->db->where('global_section_id', $section_id);
		$this->db->update('global_section', $data);
		return;
	}

	function disable($section_id) {
		$data = array();
		$data['section_is_active'] = 0;

		$this->db->where('global_section_id', $section_id);
		$this->db->update('global_section', $data);
		return;
	}

	function enableSection($section) {

		$data = array();
		$data['default_section'] = 0;
		$this->db->update('global_section', $data);

		$data = array();
		$data['default_section'] = 1;
		$this->db->where('global_section_id', $section['global_section_id']);
		$this->db->update('global_section', $data);
	}

}

?>
