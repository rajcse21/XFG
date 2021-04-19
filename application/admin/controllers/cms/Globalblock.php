<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Globalblock extends CI_Controller {

	function __construct() {
		parent::__construct();
		//Check For User Login
		$user = $this->userauth->checkAuth();
		if (!$user) {
			redirect("user");
		}
		$this->load->vars(array('active_menu' => 'cn_structure'));
	}

	//------------------------------------ Valiadtion Starts --------------------------------------------//
	// Add Function
	function valid_block_alias($str) {
		$str = url_title(strtolower($str));

		$this->db->where('block_alias', $str);
		if ($this->input->post('global_section_id', TRUE)) {
			$this->db->where('global_section_id', $this->input->post('global_section_id', TRUE));
		}
		$this->db->from('global_block');
		$block_count = $this->db->count_all_results();
		if ($block_count != 0) {
			$this->form_validation->set_message('valid_block_alias', 'Block alias is already being used!');
			return false;
		}
		return true;
	}

	// Edit Function
	function valid_block_alias_e($str) {
		$str = url_title(strtolower($str));

		$this->db->where('block_alias', $str);
		$this->db->where('global_block_id !=', $this->input->post('global_block_id', true));
		if ($this->input->post('global_section_id', TRUE)) {
			$this->db->where('global_section_id', $this->input->post('global_section_id', TRUE));
		}
		$this->db->from('global_block');
		$block_count = $this->db->count_all_results();
		if ($block_count != 0) {
			$this->form_validation->set_message('valid_block_alias_e', 'Block alias is already being used!');
			return false;
		}
		return true;
	}

	// block_type Function
	function valid_block_type($str) {
		if ($str) {
			$block_type = $this->Blocktypemodel->fetchById($str);
			if ($block_type) {
				return TRUE;
			}
			$this->form_validation->set_message('valid_block_type', 'Invalid Block Type!');
			return FALSE;
		}
		return TRUE;
	}

	//-------------------------------------- Valiadtion Ends ------------------------------------------//

	function index($section_id = false) {
		$this->load->model('cms/Globalblockmodel');
		$this->load->model('cms/Globalsectionmodel');
		$this->load->library('pagination');


		$this->meta->setTitle('Manage Global Blocks - {SITE_NAME}');

		$section = $this->Globalsectionmodel->fetchById($section_id);

		if ($section_id && !$section) {
			$this->http->show404();
			return;
		}
		$global_blocks = $this->Globalblockmodel->listAll($section_id);

		//Render View
		$inner = ['global_blocks' => $global_blocks, 'section' => $section];

		$shell = array();
		if ($section) {
			$shell['contents'] = $this->view->load('cms/globalblock/block/listing', $inner, TRUE);
		} else {
			$shell['contents'] = $this->view->load('cms/globalblock/listing', $inner, TRUE);
		}
		$this->load->view("themes/" . THEME . "/templates/default", $shell);
	}

	function add($section_id = false) {
		$this->load->model('cms/Globalblockmodel');
		$this->load->model('cms/Globalsectionmodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		$this->meta->setTitle('Add Global Block - {SITE_NAME}');

		$section = array();
		if ($section_id != 0) {
			$section = $this->Globalsectionmodel->fetchById($section_id);
			if (!$section) {
				$this->http->show404();
				return;
			}
		}

		$this->form_validation->set_rules('block_name', 'Block Name', 'trim|required');
		$this->form_validation->set_rules('block_title', 'Block Title', 'trim');
		if ($section_id != 0 && $section['global_section_id']) {
			$this->form_validation->set_rules('block_alias', 'Block Alias', 'trim|required|callback_valid_block_alias');
			$this->form_validation->set_rules('allow_duplicate', 'Allow Duplicate', 'trim');
		} else {
			$this->form_validation->set_rules('block_alias', 'Block Alias', 'trim|required');
		}

		$this->form_validation->set_rules('block_content ', 'Content ', 'trim');
		$this->form_validation->set_rules('block_image ', 'Image ', 'trim');
		$this->form_validation->set_rules('block_image_medium ', 'Block Tablet Image ', 'trim');
		$this->form_validation->set_rules('block_image_small ', 'Block Mobile Image ', 'trim');
		$this->form_validation->set_rules('block_template ', 'Template ', 'trim');

		//Link Fields
		$this->form_validation->set_rules('block_link ', 'Link ', 'trim');
		$this->form_validation->set_rules('link_text ', 'Link Text ', 'trim');
		$this->form_validation->set_rules('link_class ', 'Link Class ', 'trim');
		$this->form_validation->set_rules('link_2 ', 'Link ', 'trim');
		$this->form_validation->set_rules('link_2_text ', 'Link 2 Text ', 'trim');
		$this->form_validation->set_rules('link_2_class ', 'Link 2 Class ', 'trim');
		$this->form_validation->set_rules('link_3 ', 'Link ', 'trim');
		$this->form_validation->set_rules('link_3_text ', 'Link 3 Text ', 'trim');
		$this->form_validation->set_rules('link_3_class ', 'Link 3 Class ', 'trim');

		$this->form_validation->set_rules('block_css_class', 'BLock Class', 'trim');
		$this->form_validation->set_rules('block_css_style ', 'BLock Style ', 'trim');

		$this->form_validation->set_rules('block_icon', 'Icon ', 'trim');
		$this->form_validation->set_rules('block_desc', 'Columns ', 'trim');

		$this->form_validation->set_rules('block_col_lg', 'X Large Columns ', 'trim|required|numeric');
		$this->form_validation->set_rules('block_col_md', 'Large Columns ', 'trim|required|numeric');
		$this->form_validation->set_rules('block_col_sm', 'Medium Columns ', 'trim|required|numeric');
		$this->form_validation->set_rules('block_col_xs', 'Small Columns ', 'trim|required|numeric');

		$this->form_validation->set_rules('block_col_lg_padding', 'X Large Columns Padding ', 'trim|required|numeric');
		$this->form_validation->set_rules('block_col_md_padding', 'Large Columns Padding ', 'trim|required|numeric');
		$this->form_validation->set_rules('block_col_sm_padding', 'Medium Columns Padding ', 'trim|required|numeric');
		$this->form_validation->set_rules('block_col_xs_padding', 'Small Columns Padding ', 'trim|required|numeric');
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		$columns = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12);
		$padding_columns = array(0);

		if ($this->form_validation->run() == FALSE) {

			//Render View
			$inner = ['columns' => $columns, 'padding_columns' => $padding_columns, 'section' => $section];
			$shell = array();


			if ($section) {
				$shell['contents'] = $this->view->load('cms/globalblock/block/add', $inner, TRUE);
			} else {
				$shell['contents'] = $this->view->load('cms/globalblock/add', $inner, TRUE);
			}
			$this->load->view("themes/" . THEME . "/templates/default", $shell);
		} else {
		
			if ($section) {
				$this->Globalblockmodel->insert($section['global_section_id']);
				$this->session->set_flashdata('SUCCESS', 'globalblock_added');
				redirect("cms/globalblock/index/{$section['global_section_id']}");
			} else {
				$this->Globalblockmodel->insert();
				$this->session->set_flashdata('SUCCESS', 'globalblock_added');
				redirect("cms/globalblock/index");
			}
		}
	}

	function edit($bid = FALSE) {
		$this->load->model('cms/Globalblockmodel');
		$this->load->model('cms/Globalfieldmodel');
		$this->load->library('form_validation');

		$this->meta->setTitle('Edit Global Block - {SITE_NAME}');

		$block = $this->Globalblockmodel->fetchById($bid);
		if (!$block) {
			$this->http->show404();
			return;
		}


		$additional_fields = array();

		$additional_fields_rs = $this->Globalfieldmodel->listByBlockId($block['global_block_id']);

		if ($additional_fields_rs) {
			$arr = json_decode($block['additional_fields'], TRUE);
			foreach ($additional_fields_rs as $field) {
				if ($arr && array_key_exists($field['field_alias'], $arr)) {
					$field['field_value'] = $arr[$field['field_alias']];
				}

				$additional_fields[] = $field;
				$this->form_validation->set_rules($field['field_label'], $field['field_alias'], 'trim');
			}
		}


		$is_global_block = false;
		if ($block['global_section_id'] == 0) {
			$is_global_block = true;
		}
		$this->form_validation->set_rules('block_name', 'Block Name', 'trim|required');
		$this->form_validation->set_rules('block_title', 'Block Title', 'trim');
		if ($block['global_section_id'] != 0) {
			$this->form_validation->set_rules('block_alias', 'Block Alias', 'trim|required|callback_valid_block_alias_e');
			$this->form_validation->set_rules('allow_duplicate', 'Allow Duplicate', 'trim');
		} else {
			$this->form_validation->set_rules('block_alias', 'Block Alias', 'trim|required');
		}
		$this->form_validation->set_rules('block_content', 'Content', 'trim');
		$this->form_validation->set_rules('block_image', 'Image', 'trim');
		$this->form_validation->set_rules('block_image_medium', 'Block Tablet Image', 'trim');
		$this->form_validation->set_rules('block_image_small', 'Block Mobile Image', 'trim');
		$this->form_validation->set_rules('block_template', 'Template', 'trim');

		//Link Fields
		$this->form_validation->set_rules('block_link ', 'Link ', 'trim');
		$this->form_validation->set_rules('link_text ', 'Link Text ', 'trim');
		$this->form_validation->set_rules('link_class ', 'Link Class ', 'trim');
		$this->form_validation->set_rules('link_2 ', 'Link ', 'trim');
		$this->form_validation->set_rules('link_2_text ', 'Link 2 Text ', 'trim');
		$this->form_validation->set_rules('link_2_class ', 'Link 2 Class ', 'trim');
		$this->form_validation->set_rules('link_3 ', 'Link ', 'trim');
		$this->form_validation->set_rules('link_3_text ', 'Link 3 Text ', 'trim');
		$this->form_validation->set_rules('link_3_class ', 'Link 3 Class ', 'trim');

		$this->form_validation->set_rules('block_css_class', 'BLock Class', 'trim');
		$this->form_validation->set_rules('block_css_style', 'BLock Style', 'trim');

		$this->form_validation->set_rules('block_icon', 'Icon', 'trim');
		$this->form_validation->set_rules('block_desc', 'Columns', 'trim');

		$this->form_validation->set_rules('block_col_lg', 'X Large Columns', 'trim|required|numeric');
		$this->form_validation->set_rules('block_col_md', 'Large Columns', 'trim|required|numeric');
		$this->form_validation->set_rules('block_col_sm', 'Medium Columns', 'trim|required|numeric');
		$this->form_validation->set_rules('block_col_xs', 'Small Columns', 'trim|required|numeric');

		$this->form_validation->set_rules('block_col_lg_padding', 'X Large Columns Padding', 'trim|required|numeric');
		$this->form_validation->set_rules('block_col_md_padding', 'Large Columns Padding', 'trim|required|numeric');
		$this->form_validation->set_rules('block_col_sm_padding', 'Medium Columns Padding', 'trim|required|numeric');
		$this->form_validation->set_rules('block_col_xs_padding', 'Small Columns Padding', 'trim|required|numeric');
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		$columns = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12);
		$padding_columns = array_merge(array(0), $columns);

		if ($this->form_validation->run() == FALSE) {

			//Render View
			$inner = ['block' => $block, 'columns' => $columns, 'padding_columns' => $padding_columns, 'additional_fields' => $additional_fields];
			$shell = array();


			if ($is_global_block) {
				$shell['contents'] = $this->view->load('cms/globalblock/edit', $inner, TRUE);
			} else {
				$shell['contents'] = $this->view->load('cms/globalblock/block/edit', $inner, TRUE);
			}
			$this->load->view("themes/" . THEME . "/templates/default", $shell);
		} else {

			$this->Globalblockmodel->update($block);
			$this->session->set_flashdata('SUCCESS', 'block_updated');
			if ($is_global_block) {
				redirect("cms/globalblock/index");
			} else {
				redirect("cms/globalblock/index/{$block['global_section_id']}");
			}
		}
	}

	function delete($bid = false) {
		$this->load->model('cms/Globalblockmodel');

		$block = $this->Globalblockmodel->fetchById($bid);
		if (!$block) {
			$this->http->show404();
			return;
		}

		$this->Globalblockmodel->delete($block['global_block_id']);

		$this->session->set_flashdata('SUCCESS', 'globalblock_deleted');
		if ($block['global_section_id'] != 0) {
			redirect("cms/globalblock/index/{$block['global_section_id']}");
		} else {
			redirect("cms/globalblock/index");
		}
	}

	function enable($bid = FALSE) {
		$this->load->model('cms/Globalblockmodel');

		$block = $this->Globalblockmodel->fetchById($bid);
		if (!$block) {
			$this->http->show404();
			return;
		}

		$this->Globalblockmodel->enable($block['global_block_id']);
		$this->session->set_flashdata('SUCCESS', 'globalblock_enable');

		if ($block['global_section_id'] != 0) {
			redirect("cms/globalblock/index/{$block['global_section_id']}");
		} else {
			redirect("cms/globalblock/index");
		}
	}

	function disable($bid = FALSE) {
		$this->load->model('cms/Globalblockmodel');

		$block = $this->Globalblockmodel->fetchById($bid);
		//print_r($block); die;
		if (!$block) {
			$this->http->show404();
			return;
		}

		$this->Globalblockmodel->disable($block['global_block_id']);
		$this->session->set_flashdata('SUCCESS', 'globalblock_disable');

		if ($block['global_section_id'] != 0) {
			redirect("cms/globalblock/index/{$block['global_section_id']}");
		} else {
			redirect("cms/globalblock/index");
		}
	}

}

?>