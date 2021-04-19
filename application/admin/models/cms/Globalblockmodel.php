<?php

class Globalblockmodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function fetchById($bid) {
		$this->db->where('global_block_id', intval($bid));
		$rs = $this->db->get('global_block');
		if ($rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return FALSE;
	}

	function countAll() {
		$this->db->from('global_block');
		return $this->db->count_all_results();
	}

	function fetchByBlockType($offset = FALSE, $limit = FALSE) {
		if ($offset)
			$this->db->offset($offset);
		if ($limit)
			$this->db->limit($limit);

		$this->db->where('global_section_id', 0);
		$this->db->order_by('block_sort_order', 'ASC');
		$rs = $this->db->get('global_block');
		if ($rs && $rs->num_rows() > 0) {
			return $rs->result_array();
		}
		return FALSE;
	}

	function listAll($section_id = false) {
		if ($section_id) {
			$this->db->join('global_section', 'global_section.global_section_id = global_block.global_section_id');
			$this->db->where('global_block.global_section_id', intval($section_id));
		} else {
			$this->db->where('global_block.global_section_id', 0);
		}
		$this->db->order_by('block_sort_order', 'ASC');
		$rs = $this->db->get('global_block');
		if ($rs && $rs->num_rows() > 0) {
			return $rs->result_array();
		}
		return FALSE;
	}

	function getOrder($section_id = false) {
		$this->db->select_max('block_sort_order');
		if ($section_id) {
			$this->db->where('global_section_id', $section_id);
		}
		$query = $this->db->get('global_block');
		$sort_order = $query->row_array();
		return $sort_order['block_sort_order'] + 1;
	}

	function insert($section_id = 0) {
		$data = array();
		$data['block_name'] = $this->input->post('block_name', TRUE);
		$data['block_title'] = $this->input->post('block_title', TRUE);
		$data['block_alias'] = url_title(strtolower($this->input->post('block_alias', TRUE)));
		$data['block_content'] = $this->input->post('block_content', FALSE);
		$data['block_image'] = $this->input->post('block_image', TRUE);
		$data['block_image_medium'] = $this->input->post('block_image_medium', TRUE);
		$data['block_image_small'] = $this->input->post('block_image_small', TRUE);

		$data['block_link'] = $this->input->post('block_link', FALSE) ? $this->input->post('block_link', FALSE) : '';
		$data['link_text'] = $this->input->post('link_text', FALSE) ? $this->input->post('link_text', FALSE) : '';
		$data['link_class'] = $this->input->post('link_class', FALSE) ? $this->input->post('link_class', FALSE) : '';

		$data['link_2'] = $this->input->post('link_2', FALSE) ? $this->input->post('link_2', FALSE) : '';
		$data['link_2_text'] = $this->input->post('link_2_text', FALSE) ? $this->input->post('link_2_text', FALSE) : '';
		$data['link_2_class'] = $this->input->post('link_2_class', FALSE) ? $this->input->post('link_2_class', FALSE) : '';

		$data['link_3'] = $this->input->post('link_3', FALSE) ? $this->input->post('link_3', FALSE) : '';
		$data['link_3_text'] = $this->input->post('link_3_text', FALSE) ? $this->input->post('link_3_text', FALSE) : '';
		$data['link_3_class'] = $this->input->post('link_3_class', FALSE) ? $this->input->post('link_3_class', FALSE) : '';

		$data['block_desc'] = '';
		if ($this->input->post('block_desc', FALSE)) {
			$data['block_desc'] = $this->input->post('block_desc', FALSE);
		}
		$data['block_icon'] = '';
		if ($this->input->post('block_icon', FALSE)) {
			$data['block_icon'] = $this->input->post('block_icon', TRUE);
		}

		$data['block_template'] = $this->input->post('block_template', FALSE);

		$data['block_css_class'] = $this->input->post('block_css_class', TRUE);
		$data['block_css_style'] = $this->input->post('block_css_style', TRUE);
		if ($section_id != 0) {
			$data['allow_duplicate'] = $this->input->post('allow_duplicate', TRUE);
		}
		$data['block_sort_order'] = $this->getOrder($section_id);
		$data['global_section_id'] = $section_id;
		$data['block_is_active'] = 1;

		$data['block_col_lg'] = ($this->input->post('block_col_lg', TRUE)) ? $this->input->post('block_col_lg', TRUE) : 12;
		$data['block_col_md'] = ($this->input->post('block_col_md', TRUE)) ? $this->input->post('block_col_md', TRUE) : 12;
		$data['block_col_sm'] = ($this->input->post('block_col_sm', TRUE)) ? $this->input->post('block_col_sm', TRUE) : 12;
		$data['block_col_xs'] = ($this->input->post('block_col_xs', TRUE)) ? $this->input->post('block_col_xs', TRUE) : 12;

		$data['block_col_lg_padding'] = ($this->input->post('block_col_lg_padding', TRUE)) ? $this->input->post('block_col_lg_padding', TRUE) : 0;
		$data['block_col_md_padding'] = ($this->input->post('block_col_md_padding', TRUE)) ? $this->input->post('block_col_md_padding', TRUE) : 0;
		$data['block_col_sm_padding'] = ($this->input->post('block_col_sm_padding', TRUE)) ? $this->input->post('block_col_sm_padding', TRUE) : 0;
		$data['block_col_xs_padding'] = ($this->input->post('block_col_xs_padding', TRUE)) ? $this->input->post('block_col_xs_padding', TRUE) : 0;
		$data['block_updated_on'] = time();
		$this->db->insert('global_block', $data);
	}

	function update($block) {
		$data = array();
		$data['block_name'] = $this->input->post('block_name', TRUE);
		$data['block_title'] = $this->input->post('block_title', TRUE);
		$data['block_alias'] = url_title(strtolower($this->input->post('block_alias', TRUE)));
		$data['block_content'] = $this->input->post('block_content', FALSE);
		$data['block_image'] = $this->input->post('block_image', TRUE);
		$data['block_image_medium'] = $this->input->post('block_image_medium', TRUE);
		$data['block_image_small'] = $this->input->post('block_image_small', TRUE);

		$data['block_link'] = $this->input->post('block_link', FALSE) ? $this->input->post('block_link', FALSE) : '';
		$data['link_text'] = $this->input->post('link_text', FALSE) ? $this->input->post('link_text', FALSE) : '';
		$data['link_class'] = $this->input->post('link_class', FALSE) ? $this->input->post('link_class', FALSE) : '';

		$data['link_2'] = $this->input->post('link_2', FALSE) ? $this->input->post('link_2', FALSE) : '';
		$data['link_2_text'] = $this->input->post('link_2_text', FALSE) ? $this->input->post('link_2_text', FALSE) : '';
		$data['link_2_class'] = $this->input->post('link_2_class', FALSE) ? $this->input->post('link_2_class', FALSE) : '';

		$data['link_3'] = $this->input->post('link_3', FALSE) ? $this->input->post('link_3', FALSE) : '';
		$data['link_3_text'] = $this->input->post('link_3_text', FALSE) ? $this->input->post('link_3_text', FALSE) : '';
		$data['link_3_class'] = $this->input->post('link_3_class', FALSE) ? $this->input->post('link_3_class', FALSE) : '';

		$data['block_desc'] = $this->input->post('block_desc', FALSE);
		$data['block_icon'] = $this->input->post('block_icon', TRUE);

		if ($block['global_section_id'] != 0) {
			$data['allow_duplicate'] = $this->input->post('allow_duplicate', TRUE);
		}

		$data['block_template'] = $this->input->post('block_template', FALSE);

		$data['block_css_class'] = $this->input->post('block_css_class', TRUE);
		$data['block_css_style'] = $this->input->post('block_css_style', TRUE);

		$data['block_col_lg'] = ($this->input->post('block_col_lg', TRUE)) ? $this->input->post('block_col_lg', TRUE) : 12;
		$data['block_col_md'] = ($this->input->post('block_col_md', TRUE)) ? $this->input->post('block_col_md', TRUE) : 12;
		$data['block_col_sm'] = ($this->input->post('block_col_sm', TRUE)) ? $this->input->post('block_col_sm', TRUE) : 12;
		$data['block_col_xs'] = ($this->input->post('block_col_xs', TRUE)) ? $this->input->post('block_col_xs', TRUE) : 12;

		$data['block_col_lg_padding'] = ($this->input->post('block_col_lg_padding', TRUE)) ? $this->input->post('block_col_lg_padding', TRUE) : 0;
		$data['block_col_md_padding'] = ($this->input->post('block_col_md_padding', TRUE)) ? $this->input->post('block_col_md_padding', TRUE) : 0;
		$data['block_col_sm_padding'] = ($this->input->post('block_col_sm_padding', TRUE)) ? $this->input->post('block_col_sm_padding', TRUE) : 0;
		$data['block_col_xs_padding'] = ($this->input->post('block_col_xs_padding', TRUE)) ? $this->input->post('block_col_xs_padding', TRUE) : 0;

		$additional_fields = $this->Globalfieldmodel->listByBlockId($block['global_block_id']);
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
			$data['additional_fields'] = json_encode($fields);
		}

		$data['block_updated_on'] = time();

		$this->db->where('global_block_id', $block['global_block_id']);
		$this->db->update('global_block', $data);
	}

	function delete($block_id) {
		//Delete additional fields
		$this->db->where('global_block_id', $block_id);
		$this->db->delete('globalblock_field');
		
		$this->db->where('global_block_id', $block_id);
		$this->db->delete('global_block');
	}

	function enable($block_id) {
		$data = array();
		$data['block_is_active'] = 1;

		$this->db->where('global_block_id', $block_id);
		$this->db->update('global_block', $data);
		return;
	}

	function disable($block_id) {
		$data = array();
		$data['block_is_active'] = 0;

		$this->db->where('global_block_id', $block_id);
		$this->db->update('global_block', $data);
		return;
	}

}

?>
