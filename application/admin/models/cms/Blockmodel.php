<?php

class Blockmodel extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

	function fetchById($bid) {
		$this->db->where('page_block_id', $bid);
		$rs = $this->db->get('page_block');
		if ($rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return false;
	}

	function getOrder($sid) {
		$this->db->select_max('page_block_sort_order');
		$this->db->where('page_section_id', $sid);
		$query = $this->db->get('page_block');
		$sort_order = $query->row_array();
		return $sort_order['page_block_sort_order'] + 1;
	}

	function listBySection($sid) {
		$this->db->where('page_section_id', $sid);
		$this->db->order_by('page_block_sort_order', 'ASC');
		$rs = $this->db->get('page_block');
		if ($rs && $rs->num_rows() > 0) {
			return $rs->result_array();
		}
		return false;
	}

	function listByPage($page_i18n_id) {
		$this->db->select('page_block.*,global_block.block_name as global_block_name,block_type.block_type');
		$this->db->join('global_block', 'global_block.global_block_id = page_block.global_block_id', 'LEFT');
		$this->db->join('block_type', 'block_type.block_type_id = page_block.block_type_id', 'LEFT');
		$this->db->where('page_i18n_id', $page_i18n_id);
		$this->db->order_by('block_sort_order', 'ASC');
		$rs = $this->db->get('page_block');
		if ($rs && $rs->num_rows() > 0) {
			return $rs->result_array();
		}
		return false;
	}

	function insertRecord($section) {
		$data = array();

		if ($section['global_section_id'] == 0) {
			$data['page_global_block_id'] = 0;
		}
		$data['page_i18n_id'] = $section['page_i18n_id'];
		$data['page_section_id'] = $section['page_section_id'];
		$data['page_block_name'] = '';
		if ($this->input->post('page_block_name', TRUE) && $this->input->post('page_block_name', TRUE) != '') {
			$data['page_block_name'] = $this->input->post('page_block_name', TRUE);
		}
		$data['page_block_alias'] = '';
		if ($this->input->post('page_block_alias', TRUE) && $this->input->post('page_block_alias', TRUE) != '') {
			$data['page_block_alias'] = url_title(strtolower($this->input->post('page_block_alias', TRUE)));
		}
		$data['page_block_title'] = $this->input->post('page_block_title', TRUE);
		$data['page_block_content'] = $this->input->post('page_block_content', FALSE);
		$data['page_block_image'] = $this->input->post('page_block_image', TRUE);
		$data['page_block_image_medium'] = $this->input->post('page_block_image_medium', TRUE);
		$data['page_block_image_small'] = $this->input->post('page_block_image_small', TRUE);

		$data['page_block_link'] = $this->input->post('page_block_link', FALSE) ? $this->input->post('page_block_link', FALSE) : '';
		$data['page_block_link_text'] = $this->input->post('page_block_link_text', FALSE) ? $this->input->post('page_block_link_text', FALSE) : '';
		$data['page_block_link_class'] = $this->input->post('page_block_link_class', FALSE) ? $this->input->post('page_block_link_class', FALSE) : '';

		$data['page_block_link2'] = $this->input->post('page_block_link2', FALSE) ? $this->input->post('page_block_link2', FALSE) : '';
		$data['page_block_link_text2'] = $this->input->post('page_block_link_text2', FALSE) ? $this->input->post('page_block_link_text2', FALSE) : '';
		$data['page_block_link_class2'] = $this->input->post('page_block_link_class2', FALSE) ? $this->input->post('page_block_link_class2', FALSE) : '';

		$data['page_block_link3'] = $this->input->post('page_block_link3', FALSE) ? $this->input->post('page_block_link3', FALSE) : '';
		$data['page_block_link_text3'] = $this->input->post('page_block_link_text3', FALSE) ? $this->input->post('page_block_link_text3', FALSE) : '';
		$data['page_block_link_class3'] = $this->input->post('page_block_link_class3', FALSE) ? $this->input->post('page_block_link_class3', FALSE) : '';


		if ($section['global_section_id'] == 0) {
			$data['page_block_template'] = $this->input->post('page_block_template', FALSE);
		}
		$data['page_block_css_class'] = $this->input->post('page_block_css_class', TRUE);
		$data['page_block_css_style'] = $this->input->post('page_block_css_style', FALSE);
		$data['page_block_sort_order'] = $this->getOrder($data['page_section_id']);

		$data['page_block_is_active'] = 1;

		$data['page_block_col_lg'] = ($this->input->post('page_block_col_lg', TRUE)) ? $this->input->post('page_block_col_lg', TRUE) : 12;
		$data['page_block_col_md'] = ($this->input->post('page_block_col_md', TRUE)) ? $this->input->post('page_block_col_md', TRUE) : 12;
		$data['page_block_col_sm'] = ($this->input->post('page_block_col_sm', TRUE)) ? $this->input->post('page_block_col_sm', TRUE) : 12;
		$data['page_block_col_xs'] = ($this->input->post('page_block_col_xs', TRUE)) ? $this->input->post('page_block_col_xs', TRUE) : 12;

		$data['page_block_col_lg_padding'] = ($this->input->post('page_block_col_lg_padding', TRUE)) ? $this->input->post('page_block_col_lg_padding', TRUE) : 0;
		$data['page_block_col_md_padding'] = ($this->input->post('page_block_col_md_padding', TRUE)) ? $this->input->post('page_block_col_md_padding', TRUE) : 0;
		$data['page_block_col_sm_padding'] = ($this->input->post('page_block_col_sm_padding', TRUE)) ? $this->input->post('page_block_col_sm_padding', TRUE) : 0;
		$data['page_block_col_xs_padding'] = ($this->input->post('page_block_col_xs_padding', TRUE)) ? $this->input->post('page_block_col_xs_padding', TRUE) : 0;

		$data['page_block_updated_on'] = time();

		$data['page_additional_fields'] = '';
		$this->db->insert('page_block', $data);
		$page_block_id = $this->db->insert_id();
		if ($page_block_id && $data['page_block_alias'] == '') {
			$update = array();
			$update['page_block_alias'] = 'block-' . $page_block_id;
			$this->db->where('page_block_id', $page_block_id);
			$this->db->update('page_block', $update);
		}
	}

	function insert_duplicate_block($block) {
		$data = array();
		$data['page_global_block_id'] = $block['page_global_block_id'];

		$data['page_i18n_id'] = $block['page_i18n_id'];
		$data['page_section_id'] = $block['page_section_id'];
		$data['page_block_name'] = $block['page_block_name'];
		$data['page_block_title'] = $block['page_block_title'];
		$data['page_block_alias'] = 'block';
		$data['page_block_content'] = $block['page_block_content'];
		$data['page_block_image'] = $block['page_block_image'];
		$data['page_block_image_medium'] = $block['page_block_image_medium'];
		$data['page_block_image_small'] = $block['page_block_image_small'];
		$data['page_block_link'] = $block['page_block_link'];
		$data['page_block_link_text'] = $block['page_block_link_text'];

		$data['page_block_template'] = $block['page_block_template'];
		$data['page_block_css_class'] = $block['page_block_css_class'];
		$data['page_block_css_style'] = $block['page_block_css_style'];
		$data['page_block_sort_order'] = $this->getOrder($block['page_section_id']);

		$data['page_block_is_active'] = 1;

		$data['page_block_col_lg'] = $block['page_block_col_lg'];
		$data['page_block_col_md'] = $block['page_block_col_md'];
		$data['page_block_col_sm'] = $block['page_block_col_sm'];
		$data['page_block_col_xs'] = $block['page_block_col_xs'];

		$data['page_block_col_lg_padding'] = $block['page_block_col_lg_padding'];
		$data['page_block_col_md_padding'] = $block['page_block_col_md_padding'];
		$data['page_block_col_sm_padding'] = $block['page_block_col_sm_padding'];
		$data['page_block_col_xs_padding'] = $block['page_block_col_xs_padding'];
		$data['page_block_updated_on'] = time();
		$data['page_additional_fields'] = $block['page_additional_fields'];

		$status=$this->db->insert('page_block', $data);
		
		$page_block_id = $this->db->insert_id();
		if ($page_block_id) {
			$update = array();
			$update['page_block_alias'] = 'block-' . $page_block_id;
			$this->db->where('page_block_id', $page_block_id);
			$status = $this->db->update('page_block', $update);			
		}
	
		return $status;
	}

	function updateRecord($block) {

		$data = array();

		if ($this->input->post('page_global_block_id', TRUE)) {
			$data['page_global_block_id'] = $this->input->post('page_global_block_id', TRUE);
		} else {
			$data['page_global_block_id'] = $block['page_global_block_id'];
		}
		$data['page_block_title'] = $this->input->post('page_block_title', TRUE);

		$data['page_block_name'] = $this->input->post('page_block_name', TRUE);
		$data['page_block_alias'] = 'block-' . $block['page_block_id'];
		if ($this->input->post('page_block_alias', TRUE)) {
			$data['page_block_alias'] = url_title(strtolower($this->input->post('page_block_alias', TRUE)));
		}



		$data['page_block_content'] = $this->input->post('page_block_content', FALSE);
		$data['page_block_image'] = $this->input->post('page_block_image', TRUE);
		$data['page_block_image_medium'] = $this->input->post('page_block_image_medium', TRUE);
		$data['page_block_image_small'] = $this->input->post('page_block_image_small', TRUE);

		$data['page_block_link'] = $this->input->post('page_block_link', FALSE) ? $this->input->post('page_block_link', FALSE) : '';
		$data['page_block_link_text'] = $this->input->post('page_block_link_text', FALSE) ? $this->input->post('page_block_link_text', FALSE) : '';
		$data['page_block_link_class'] = $this->input->post('page_block_link_class', FALSE) ? $this->input->post('page_block_link_class', FALSE) : '';

		$data['page_block_link2'] = $this->input->post('page_block_link2', FALSE) ? $this->input->post('page_block_link2', FALSE) : '';
		$data['page_block_link_text2'] = $this->input->post('page_block_link_text2', FALSE) ? $this->input->post('page_block_link_text2', FALSE) : '';
		$data['page_block_link_class2'] = $this->input->post('page_block_link_class2', FALSE) ? $this->input->post('page_block_link_class2', FALSE) : '';

		$data['page_block_link3'] = $this->input->post('page_block_link3', FALSE) ? $this->input->post('page_block_link3', FALSE) : '';
		$data['page_block_link_text3'] = $this->input->post('page_block_link_text3', FALSE) ? $this->input->post('page_block_link_text3', FALSE) : '';
		$data['page_block_link_class3'] = $this->input->post('page_block_link_class3', FALSE) ? $this->input->post('page_block_link_class3', FALSE) : '';


		if ($block['page_global_block_id'] == 0) {
			$data['page_block_template'] = $this->input->post('page_block_template', FALSE);
		}
		$data['page_block_css_class'] = $this->input->post('page_block_css_class', TRUE);
		$data['page_block_css_style'] = $this->input->post('page_block_css_style', FALSE);

		$data['page_block_col_lg'] = ($this->input->post('page_block_col_lg', TRUE)) ? $this->input->post('page_block_col_lg', TRUE) : 12;
		$data['page_block_col_md'] = ($this->input->post('page_block_col_md', TRUE)) ? $this->input->post('page_block_col_md', TRUE) : 12;
		$data['page_block_col_sm'] = ($this->input->post('page_block_col_sm', TRUE)) ? $this->input->post('page_block_col_sm', TRUE) : 12;
		$data['page_block_col_xs'] = ($this->input->post('page_block_col_xs', TRUE)) ? $this->input->post('page_block_col_xs', TRUE) : 12;

		$data['page_block_col_lg_padding'] = ($this->input->post('page_block_col_lg_padding', TRUE)) ? $this->input->post('page_block_col_lg_padding', TRUE) : 0;
		$data['page_block_col_md_padding'] = ($this->input->post('page_block_col_md_padding', TRUE)) ? $this->input->post('page_block_col_md_padding', TRUE) : 0;
		$data['page_block_col_sm_padding'] = ($this->input->post('page_block_col_sm_padding', TRUE)) ? $this->input->post('page_block_col_sm_padding', TRUE) : 0;
		$data['page_block_col_xs_padding'] = ($this->input->post('page_block_col_xs_padding', TRUE)) ? $this->input->post('page_block_col_xs_padding', TRUE) : 0;

		$data['page_block_updated_on'] = time();

		$data['page_additional_fields'] = '';

		$additional_fields = $this->Globalfieldmodel->listByBlockId($block['page_global_block_id']);
		if ($additional_fields) {
			$fields = array();
			foreach ($additional_fields as $field) {
				if ($field['field_type'] == 'php_library') {
					$this->load->library("cms/fields/{$field['field_options']}");
					$class = strtolower($field['field_options']);
					$fields[$field['field_alias']] = $this->$class->saveField($field);
				} else {
					$fields[$field['field_alias']] = $this->input->post($field['field_alias'], FALSE);
				}
			}
			$data['page_additional_fields'] = json_encode($fields);
		}

		$this->db->where('page_block_id', $block['page_block_id']);
		$this->db->update('page_block', $data);
	}

	function deleteRecord($block) {
		$this->db->where('page_block_id', $block['page_block_id']);
		$this->db->delete('page_block');
	}

}

?>