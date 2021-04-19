<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Block extends CI_Controller {

	function __construct() {
		parent::__construct();
		//Check For User Login
		$user = $this->userauth->checkAuth();
		if (!$user) {
			redirect("user");
		}
	}

	//---------------------------------- Validation Starts -----------------------------------------//
	// Add function
	function valid_block_alias($str) {
		$str = url_title(strtolower($str));

		$this->db->where('page_block_alias', $str);
		$this->db->where('page_section_id', $this->input->post('section_id', TRUE));
		$this->db->from('page_block');
		$block_count = $this->db->count_all_results();
		if ($block_count != 0) {
			$this->form_validation->set_message('valid_block_alias', 'Block alias is already being used!');
			return false;
		}
		return true;
	}

	// Edit function
	function valid_block_alias_e($str) {
		$str = url_title(strtolower($str));

		$this->db->where('page_block_alias', $str);
		$this->db->where('page_block_id !=', $this->input->post('page_block_id', true));
		$this->db->where('page_section_id', $this->input->post('section_id', TRUE));
		$this->db->from('page_block');
		$block_count = $this->db->count_all_results();
		if ($block_count != 0) {
			$this->form_validation->set_message('valid_block_alias_e', 'Block alias is already being used!');
			return FALSE;
		}
		return true;
	}

	//---------------------------------- Validation Ends -----------------------------------------//
	function index($page_section_id = false) {
		$this->load->model('cms/Pagesectionmodel');
		$this->load->model('cms/Blockmodel');
		$this->load->model('cms/blocktype/Blocktypemodel');
		$this->load->model('cms/Pagemodel');
		$this->load->helper('text');

		$this->meta->setTitle('Manages Page Section - {SITE_NAME}');

		$sections = $this->Pagesectionmodel->fetchById($page_section_id);

		$blocks = $this->Blockmodel->listBySection($sections['page_section_id']);

		$inner = array();
		$inner['sections'] = $sections;
		$inner['blocks'] = $blocks;

		$page = array();
		$page['content'] = $this->view->load('cms/pages/block/listing', $inner, TRUE);
		$this->load->view("themes/" . THEME . "/templates/default", $page);
	}

	function add($sid = FALSE) {
		$this->load->model('cms/Pagemodel');
		$this->load->model('cms/Blockmodel');
		$this->load->model('cms/Pagesectionmodel');
		$this->load->model('cms/Globalblockmodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		$section = $this->Pagesectionmodel->fetchById($sid);
		if (!$section) {
			$this->http->show404();
			return;
		}

		$page_details = $this->Pagemodel->fetchById($section['page_i18n_id']);
		if (!$page_details) {
			$this->http->show404();
			return;
		}

		$this->meta->setTitle('Add Block - {SITE_NAME}');

		$this->form_validation->set_rules('page_block_name', 'Block Name', 'trim|required');
		$this->form_validation->set_rules('page_block_title', 'Block Title', 'trim');
		$this->form_validation->set_rules('page_block_alias', 'Block Alias', 'trim');
		$this->form_validation->set_rules('page_block_content', 'Content', 'trim');
		$this->form_validation->set_rules('page_block_image', 'Block Image', 'trim');
		$this->form_validation->set_rules('page_block_image_medium', 'Block Tablet Image', 'trim');
		$this->form_validation->set_rules('page_block_image_small', 'Block Mobile Image', 'trim');
		if ($section['global_section_id'] == 0) {
			$this->form_validation->set_rules('page_block_template', 'Template', 'trim');
		}

		//Links
		$this->form_validation->set_rules('page_block_link', 'Link', 'trim');
		$this->form_validation->set_rules('page_block_link_text', 'Link Text', 'trim');
		$this->form_validation->set_rules('page_block_link_class', 'Link Class', 'trim');
		$this->form_validation->set_rules('page_block_link2', 'Link2', 'trim');
		$this->form_validation->set_rules('page_block_link_text2', 'Link Text2', 'trim');
		$this->form_validation->set_rules('page_block_link_class2', 'Link Class2', 'trim');
		$this->form_validation->set_rules('page_block_link3', 'Link3', 'trim');
		$this->form_validation->set_rules('page_block_link_text3', 'Link Text3', 'trim');
		$this->form_validation->set_rules('page_block_link_class3', 'Link Class3', 'trim');

		$this->form_validation->set_rules('page_block_css_class', 'BLock Class', 'trim');
		$this->form_validation->set_rules('page_block_css_style', 'BLock Style', 'trim');

		$this->form_validation->set_rules('page_block_col_lg', 'X Large Columns', 'trim|required|numeric');
		$this->form_validation->set_rules('page_block_col_md', 'Large Columns', 'trim|required|numeric');
		$this->form_validation->set_rules('page_block_col_sm', 'Medium Columns', 'trim|required|numeric');
		$this->form_validation->set_rules('page_block_col_xs', 'Small Columns', 'trim|required|numeric');

		$this->form_validation->set_rules('page_block_col_lg_padding', 'X Large Columns Padding', 'trim|required|numeric');
		$this->form_validation->set_rules('page_block_col_md_padding', 'Large Columns Padding', 'trim|required|numeric');
		$this->form_validation->set_rules('page_block_col_sm_padding', 'Medium Columns Padding', 'trim|required|numeric');
		$this->form_validation->set_rules('page_block_col_xs_padding', 'Small Columns Padding', 'trim|required|numeric');

		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		$columns = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12);
		$padding_columns = array(0);

		if ($this->form_validation->run() == FALSE) {
			$inner = $page = array();

			$inner['section'] = $section;
			$inner['columns'] = $columns;
			$inner['padding_columns'] = $padding_columns;
			$inner['page_details'] = $page_details;

			$page['contents'] = $this->view->load('cms/pages/block/add', $inner, TRUE);
			$this->load->view("themes/" . THEME . "/templates/popup", $page);
		} else {
			$this->Blockmodel->insertRecord($section);
			redirect("cms/block/added");
		}
	}

	function added() {
		$this->load->model('cms/Pagesectionmodel');
		$this->load->model('cms/Pagemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');


		$this->meta->setTitle('Add Page Block - {SITE_NAME}');

		$page = array();
		$page['contents'] = "<input type='hidden' name='page_section_success' class='page_section_success'/><h1>Success</h1><p>Block added successfully!</p>";
		$this->load->view('themes/' . THEME . '/templates/popup', $page);
	}

	function edit($bid = false) {

		$this->load->model('cms/Pagemodel');
		$this->load->model('cms/Blockmodel');
		$this->load->model('cms/Pagesectionmodel');
		$this->load->model('cms/Globalblockmodel');
		$this->load->model('cms/Globalfieldmodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		$block = $this->Blockmodel->fetchById($bid);
		if (!$block) {
			$this->http->show404();
			return;
		}

		$section = $this->Pagesectionmodel->fetchById($block['page_section_id']);
		if (!$section) {
			$this->http->show404();
			return;
		}

		$this->meta->setTitle('Edit Block - {SITE_NAME}');

		$additional_fields = array();

		$additional_fields_rs = $this->Globalfieldmodel->listByBlockId($block['page_global_block_id']);

		if ($additional_fields_rs) {
			$arr = json_decode($block['page_additional_fields'], TRUE);
			//if ($arr) {
			foreach ($additional_fields_rs as $field) {
				//	$field['field_value'] = '';
				if ($arr && array_key_exists($field['field_alias'], $arr)) {
					$field['field_value'] = $arr[$field['field_alias']];
				}
				$additional_fields[] = $field;
				$this->form_validation->set_rules($field['field_label'], $field['field_alias'], 'trim');
			}
			//}
		}

		$this->form_validation->set_rules('page_block_name', 'Block Name', 'trim|required');
		$this->form_validation->set_rules('page_block_title', 'Block Title', 'trim');
		$this->form_validation->set_rules('page_block_alias', 'Block Alias', 'trim');
		$this->form_validation->set_rules('page_block_content', 'Content', 'trim');
		$this->form_validation->set_rules('page_block_image', 'Block Image', 'trim');
		$this->form_validation->set_rules('page_block_image_medium', 'Block Tablet Image', 'trim');
		$this->form_validation->set_rules('page_block_image_small', 'Block Mobile Image', 'trim');
		if ($section['global_section_id'] == 0) {
			$this->form_validation->set_rules('page_block_template', 'Template', 'trim');
		}

		//Links
		$this->form_validation->set_rules('page_block_link', 'Link', 'trim');
		$this->form_validation->set_rules('page_block_link_text', 'Link Text', 'trim');
		$this->form_validation->set_rules('page_block_link_class', 'Link Class', 'trim');
		$this->form_validation->set_rules('page_block_link2', 'Link2', 'trim');
		$this->form_validation->set_rules('page_block_link_text2', 'Link Text2', 'trim');
		$this->form_validation->set_rules('page_block_link_class2', 'Link Class2', 'trim');
		$this->form_validation->set_rules('page_block_link3', 'Link3', 'trim');
		$this->form_validation->set_rules('page_block_link_text3', 'Link Text3', 'trim');
		$this->form_validation->set_rules('page_block_link_class3', 'Link Class3', 'trim');


		$this->form_validation->set_rules('page_block_css_class', 'BLock Class', 'trim');
		$this->form_validation->set_rules('page_block_css_style', 'BLock Style', 'trim');

		$this->form_validation->set_rules('page_block_col_lg', 'X Large Columns', 'trim|required|numeric');
		$this->form_validation->set_rules('page_block_col_md', 'Large Columns', 'trim|required|numeric');
		$this->form_validation->set_rules('page_block_col_sm', 'Medium Columns', 'trim|required|numeric');
		$this->form_validation->set_rules('page_block_col_xs', 'Small Columns', 'trim|required|numeric');

		$this->form_validation->set_rules('page_block_col_lg_padding', 'X Large Columns Padding', 'trim|required|numeric');
		$this->form_validation->set_rules('page_block_col_md_padding', 'Large Columns Padding', 'trim|required|numeric');
		$this->form_validation->set_rules('page_block_col_sm_padding', 'Medium Columns Padding', 'trim|required|numeric');
		$this->form_validation->set_rules('page_block_col_xs_padding', 'Small Columns Padding', 'trim|required|numeric');

		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		$columns = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12);
		$padding_columns = array_merge(array(0), $columns);

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$page = array();
			$inner['section'] = $section;
			$inner['block'] = $block;
			$inner['additional_fields'] = $additional_fields;
			$inner['padding_columns'] = $padding_columns;
			$inner['columns'] = $columns;

			$page['contents'] = $this->view->load('cms/pages/block/edit', $inner, TRUE);
			$this->load->view("themes/" . THEME . "/templates/popup", $page);
		} else {
			$this->Blockmodel->updateRecord($block);
			redirect("cms/block/added");
		}
	}

	function delete($bid = false) {
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('cms/Pagemodel');
		$this->load->model('cms/Pagesectionmodel');
		$this->load->model('cms/Blockmodel');

		$block = $this->Blockmodel->fetchById($bid);
		if (!$block) {
			$this->http->show404();
			return;
		}

		$section = $this->Pagesectionmodel->fetchById($block['page_section_id']);
		if (!$section) {
			$this->http->show404();
			return;
		}

		$this->Blockmodel->deleteRecord($block);
		$this->session->set_flashdata('SUCCESS', 'block_deleted');

		redirect("cms/page/edit/{$block['page_i18n_id']}#content", 'location');
	}

	function duplicate_block($bid = false) {
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('cms/Pagemodel');
		$this->load->model('cms/Pagesectionmodel');
		$this->load->model('cms/Blockmodel');

		$block = $this->Blockmodel->fetchById($bid);
		if (!$block) {
			$this->http->show404();
			return;
		}

		$status = $this->Blockmodel->insert_duplicate_block($block);
		$output = array();
		$output['status'] = $status;
		$output['message'] = 'Duplicate Block Created';
		echo json_encode($output);
		exit();
	}

	function sort_order($page_section_id) {
		$this->load->model('cms/Pagesectionmodel');
		$this->load->model('cms/Blockmodel');
		$this->load->model('cms/blocktype/Blocktypemodel');
		$this->load->helper('text');

		$this->meta->setTitle('Manages Section Block');

		//$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . '/js/website/cms/block_sort.js', false, 150);

		$section = $this->Pagesectionmodel->fetchById($page_section_id);
		if (!$section) {
			$this->http->show404();
			return;
		}

		$blocks = $this->cmscore->fetchBlocksBySectionId($section['page_section_id']);

		$inner = array();
		$inner['section'] = $section;
		$inner['blocks'] = $blocks;

		$page['contents'] = $this->view->load('cms/pages/block/listing', $inner, TRUE);
		$this->load->view("themes/" . THEME . "/templates/popup", $page);
	}

}

?>