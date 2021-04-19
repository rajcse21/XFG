<?php

class Pagesectionmodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function listAll() {
		$this->db->from('page_section');
		$this->db->order_by('page_section_sort_order', 'ASC');
		$rs = $this->db->get();
		if ($rs && $rs->num_rows() > 0) {
			return $rs->result_array();
		}
		return false;
	}

	function listByPage($page_i18n_id) {
		$this->db->select('page_section.*,global_section.section_name as global_section_name');
		$this->db->join('global_section', 'global_section.global_section_id = page_section.global_section_id', 'LEFT');
		$this->db->where('page_i18n_id', intval($page_i18n_id));
		$this->db->order_by('page_section_sort_order', 'ASC');
		$query = $this->db->get('page_section');
		if ($query && $query->num_rows() > 0) {
			return $query->result_array();
		}
		return false;
	}

	function fetchPageSections($page_i18n_id) {

		$this->db->from('page_section');
		$this->db->join('global_section', 'global_section.global_section_id = page_section.global_section_id', 'LEFT');
		$this->db->where('page_i18n_id', $page_i18n_id);
		$this->db->order_by('page_section_sort_order', 'ASC');
		$rs = $this->db->get();

		if ($rs && $rs->num_rows() > 0) {
			$section_ids = array();
			$sections = array();
			$all_sections = array();
			foreach ($rs->result_array() as $row) {
				$section_ids[] = $row['page_section_id'];
				$sections[] = $row;
			}

			//Fetch All Blocks
			$section_blocks = array();
			$this->db->from('page_block');
			$this->db->join('global_block', 'global_block.global_block_id = page_block.page_global_block_id', 'LEFT');
			$this->db->where_in('page_section_id', $section_ids);
			$this->db->where('page_block_is_active', 1);
			$this->db->order_by('page_block_sort_order', 'ASC');
			$blocks_rs = $this->db->get();
			if ($blocks_rs && $blocks_rs->num_rows() > 0) {
				foreach ($blocks_rs->result_array() as $block) {
					$section_blocks[$block['page_section_id']][] = $block;
				}
			}

			if ($sections) {
				foreach ($sections as $row) {
					$tmp = $row;
					if (isset($section_blocks[$row['page_section_id']])) {
						$tmp['blocks'] = $section_blocks[$row['page_section_id']];
					}
					$all_sections[] = $tmp;
				}
			}
			return $all_sections;
		}
		return FALSE;
	}

	function fetchById($sid) {
		$this->db->where('page_section_id', intval($sid));
		$rs = $this->db->get('page_section');
		if ($rs && $rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return FALSE;
	}

	function getSortOrder($page_i18n_id) {
		$this->db->select_max('page_section_sort_order');
		$this->db->where('page_i18n_id', intval($page_i18n_id));
		$query = $this->db->get('page_section');
		$sort_order = $query->row_array();
		return $sort_order['page_section_sort_order'] + 1;
	}

	function insertRecord($page_i18n_id, $global_section_id) {
		$data = array();

		$data['page_i18n_id'] = $page_i18n_id;
		$data['global_section_id'] = $global_section_id;
		$data['page_section_name'] = $this->input->post('page_section', TRUE);

		if ($this->input->post('page_section_alias', TRUE)) {
			$data['page_section_alias'] = url_title(strtolower($this->input->post('page_section_alias', TRUE)));
		} else {
			$data['page_section_alias'] = url_title(strtolower($this->input->post('page_section', TRUE)));
		}

		$data['page_section_class'] = $this->input->post('page_section_class', TRUE);
		$data['page_section_background'] = $this->input->post('page_section_background', TRUE);
		$data['page_section_img_medium'] = $this->input->post('page_section_img_medium', TRUE);
		$data['page_section_img_small'] = $this->input->post('page_section_img_small', TRUE);

		$data['page_section_sort_order'] = $this->getSortOrder($page_i18n_id);
		if ($global_section_id == 0) {
			$data['page_section_template'] = $this->input->post('page_section_template', FALSE);
			$data['page_section_block_template'] = $this->input->post('page_section_block_template', FALSE);
		}

		$data['page_section_updated_on'] = time();
		//print_r($data); die;
		$status = $this->db->insert('page_section', $data);
		if ($status) {
			$page_section_id = $this->db->insert_id();

			if ($global_section_id == 0) {
				return $page_section_id;
			}

			//Fetch Global Blocks By Global Section Id
			$global_blocks = $this->fetchGlobalBlocksByGsid($global_section_id);

			if (!$global_blocks) {
				return;
			}
			foreach ($global_blocks as $global_block) {
				$blocks = array();

				$blocks['page_global_block_id'] = $global_block['global_block_id'];

				$blocks['page_i18n_id'] = $page_i18n_id;
				$blocks['page_section_id'] = $page_section_id;
				$blocks['page_block_name'] = $global_block['block_name'];
				$blocks['page_block_title'] = $global_block['block_title'];
				$blocks['page_block_alias'] = $global_block['block_alias'];
				$blocks['page_block_content'] = $global_block['block_content'];
				$blocks['page_block_image'] = $global_block['block_image'];
				$blocks['page_block_image_medium'] = $global_block['block_image_medium'];
				$blocks['page_block_image_small'] = $global_block['block_image_small'];
				$blocks['page_block_link'] = $global_block['block_link'];
				$blocks['page_block_link_text'] = isset($global_block['link_text']) ? $global_block['link_text'] : '';
				$blocks['page_block_template'] = '';
				$blocks['page_block_css_class'] = $global_block['block_css_class'];
				$blocks['page_block_css_style'] = $global_block['block_css_style'];
				$blocks['page_block_sort_order'] = $this->getBlockOrder($page_section_id);

				$blocks['page_block_is_active'] = $global_block['block_is_active'];

				$blocks['page_block_col_lg'] = $global_block['block_col_lg'];
				$blocks['page_block_col_md'] = $global_block['block_col_md'];
				$blocks['page_block_col_sm'] = $global_block['block_col_sm'];
				$blocks['page_block_col_xs'] = $global_block['block_col_xs'];

				$blocks['page_block_col_lg_padding'] = $global_block['block_col_lg_padding'];
				$blocks['page_block_col_md_padding'] = $global_block['block_col_md_padding'];
				$blocks['page_block_col_sm_padding'] = $global_block['block_col_sm_padding'];
				$blocks['page_block_col_xs_padding'] = $global_block['block_col_xs_padding'];
				$blocks['page_block_updated_on'] = time();
				if (isset($global_block['additional_fields']) && $global_block['additional_fields'] != '') {
					$blocks['page_additional_fields'] = $global_block['additional_fields'];
				}

				$this->db->insert('page_block', $blocks);
			}
		}
	}

	function getBlockOrder($sid) {
		$this->db->select_max('page_block_sort_order');
		$this->db->where('page_section_id', $sid);
		$query = $this->db->get('page_block');
		$sort_order = $query->row_array();
		return $sort_order['page_block_sort_order'] + 1;
	}

	function UpdateRecord($section) {
		$data = array();

		$data['page_section_name'] = $this->input->post('page_section', TRUE);
		if ($this->input->post('page_section_alias', TRUE)) {
			$data['page_section_alias'] = url_title(strtolower($this->input->post('page_section_alias', TRUE)));
		} else {
			$data['page_section_alias'] = url_title(strtolower($this->input->post('page_section', TRUE)));
		}
                $data['page_section_class'] = $this->input->post('page_section_class', TRUE);
		$data['page_section_background'] = $this->input->post('page_section_background', TRUE);
		$data['page_section_img_medium'] = $this->input->post('page_section_img_medium', TRUE);
		$data['page_section_img_small'] = $this->input->post('page_section_img_small', TRUE);
		if ($section['global_section_id'] == 0) {
			$data['page_section_template'] = $this->input->post('page_section_template', FALSE);
			$data['page_section_block_template'] = $this->input->post('page_section_block_template', FALSE);
		}

		$data['page_section_updated_on'] = time();

		$this->db->where('page_section_id', $section['page_section_id']);
		if ($this->db->update('page_section', $data)) {
			return TRUE;
		}

		return FALSE;
	}

	function deleteRecord($section_id) {
		//Delete section's blocks
		$this->db->where('page_section_id', $section_id);
		$this->db->delete('page_block');

		$this->db->where('page_section_id', $section_id);
		$this->db->delete('page_section');
	}

	// Used in Ajax's Controller
	function enableDisable($section) {
		$data = array();
		if ($section['page_section_is_active'] == 1) {
			$data['page_section_is_active'] = 0;
		} else {
			$data['page_section_is_active'] = 1;
		}

		$this->db->where('page_section_id', $section['page_section_id']);
		$this->db->update('page_section', $data);
		return TRUE;
	}

	function fetchGlobalBlocksByGsid($global_section_id) {
		$this->db->where('global_section_id', intval($global_section_id));
		$rs = $this->db->get('global_block');
		if ($rs && $rs->num_rows() > 0) {
			return $rs->result_array();
		}
	}

}

?>