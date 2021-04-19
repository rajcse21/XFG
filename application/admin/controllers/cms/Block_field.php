<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Block_field extends CI_Controller {

	function __construct() {
		parent::__construct();
		//Check For User Login
		$user = $this->userauth->checkAuth();
		if (!$user) {
			redirect("user");
		}
	}

	//------------------------------------ Validation Starts ------------------------------------------//
	// Add function
	function valid_alias($str) {
		$str = url_title(strtolower($str));

		$this->db->where('field_alias', $str);
		$this->db->where('global_block_id', $this->input->post('global_block_id', TRUE));
		$this->db->from('globalblock_field');
		$block_count = $this->db->count_all_results();
		if ($block_count != 0) {
			$this->form_validation->set_message('valid_alias', 'Field alias is already being used!');
			return FALSE;
		}
		return TRUE;
	}

	// Edit function
	function valid_alias_e($str) {
		$str = url_title(strtolower($str));

		$this->db->where('field_alias', $str);
		$this->db->where('global_block_id', $this->input->post('global_block_id', TRUE));
		$this->db->where('globalblock_field_id !=', $this->input->post('globalblock_field_id', TRUE));
		$this->db->from('globalblock_field');
		$block_count = $this->db->count_all_results();
		if ($block_count != 0) {
			$this->form_validation->set_message('valid_alias_e', 'Field alias is already being used!');
			return FALSE;
		}
		return TRUE;
	}

	//------------------------------------ Validation Ends ------------------------------------------//

	function index($bid = FALSE) {
		$this->load->model('cms/Globalblockmodel');
		$this->load->model('cms/Globalfieldmodel');
		$this->load->helper('text');


		$block = $this->Globalblockmodel->fetchById($bid);
		if (!$block) {
			$this->http->show404();
			return;
		}

		$fields = $this->Globalfieldmodel->listByBlockId($block['global_block_id']);

		$this->meta->setTitle('Manage Additional Fields - {SITE_NAME}');

		$inner = $page = array();
		$inner['block'] = $block;
		$inner['fields'] = $fields;

		$page['contents'] = $this->view->load('cms/globalblock/fields/listing', $inner, TRUE);
		$this->load->view("themes/" . THEME . "/templates/default", $page);
	}

	function add($bid = FALSE) {
		$this->load->model('cms/Globalblockmodel');
		$this->load->model('cms/Globalfieldmodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		$block = $this->Globalblockmodel->fetchById($bid);
		if (!$block) {
			$this->http->show404();
			return;
		}


		$field_type = array(
			'' => '-- Select --',
			'text' => 'Text',
			'textarea' => 'TextArea',
			'wysiwyg' => 'WYSIWYG TextArea',
			'dropdown' => 'Dropdown',
			'image' => 'Image',
			'file' => 'File'
		);

		$this->meta->setTitle('Add Additional Field - {SITE_NAME}');

		$this->form_validation->set_rules('field_type', 'Field Type', 'trim|required');
		$this->form_validation->set_rules('field_label', 'Field Label', 'trim|required');
		$this->form_validation->set_rules('field_alias', 'Field Alias', 'trim|required|callback_valid_alias');
		$this->form_validation->set_rules('field_options', 'Field Options', 'trim');
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			$inner = $page = array();
			$inner['field_type'] = $field_type;
			$inner['block'] = $block;

			$page['contents'] = $this->view->load('cms/globalblock/fields/add', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Globalfieldmodel->insertRecord($block['global_block_id']);
			$this->session->set_flashdata('SUCCESS', 'field_added');
			redirect("cms/block_field/index/{$block['global_block_id']}");
		}
	}

	function edit($fid = FALSE) {
		$this->load->model('cms/Globalblockmodel');
		$this->load->model('cms/Globalfieldmodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		$field = $this->Globalfieldmodel->fetchById($fid);
		if (!$field) {
			$this->http->show404();
			return;
		}

		$block = $this->Globalblockmodel->fetchById($field['global_block_id']);
		if (!$block) {
			$this->http->show404();
			return;
		}

		$field_type = array(
			'' => '-- Select --',
			'text' => 'Text',
			'textarea' => 'TextArea',
			'wysiwyg' => 'WYSIWYG TextArea',
			'dropdown' => 'Dropdown',
			'image' => 'Image',
			'file' => 'File'
		);

		$this->meta->setTitle('Edit Additional Field - {SITE_NAME}');

		$this->form_validation->set_rules('field_type', 'Field Type', 'trim|required');
		$this->form_validation->set_rules('field_label', 'Field Label', 'trim|required');
		$this->form_validation->set_rules('field_alias', 'Field Alias', 'trim|required|callback_valid_alias_e');
		$this->form_validation->set_rules('field_options', 'Field Options', 'trim');
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$page = array();
			$inner['field'] = $field;
			$inner['block'] = $block;
			$inner['field_type'] = $field_type;

			$page['contents'] = $this->view->load('cms/globalblock/fields/edit', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Globalfieldmodel->updateRecord($field['globalblock_field_id']);
			$this->session->set_flashdata('SUCCESS', 'field_updated');
			redirect("cms/block_field/index/{$field['global_block_id']}");
		}
	}

	function delete($fid = FALSE) {
		$this->load->model('cms/Globalfieldmodel');

		$field = $this->Globalfieldmodel->fetchById($fid);
		if (!$field) {
			$this->http->show404();
			return;
		}

		$this->Globalfieldmodel->delete($field['globalblock_field_id']);
		$this->session->set_flashdata('SUCCESS', 'block_deleted');
		redirect("cms/block_field/index/{$field['global_block_id']}");
	}

}

?>