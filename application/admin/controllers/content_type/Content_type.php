<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Content_type extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->is_admin_protected = TRUE;

		//Check For User Login
		$user = $this->userauth->checkAuth();
		if (!$user) {
			redirect("user");
		}
		$this->load->vars(array('active_menu' => 'cn_structure'));
	}

	//************************************************************ Callback function start**********************
	function valid_alias_e($str) {
		$str = url_title(strtolower($str));

		$this->db->where('content_type_alias', $str);
		$this->db->where('content_type_id !=', $this->input->post('content_type_id', true));
		$this->db->from('content_type');
		$page_count = $this->db->count_all_results();
		if ($page_count != 0) {
			$this->form_validation->set_message('valid_alias_e', 'URI Alias is already being used!');
			return false;
		}
		return true;
	}

	//************************************************************ Callback function end**********************

	function index($offset = 0) {
		$this->load->model('cms/contenttype/Contenttypemodel');
		$this->load->helper('text');


		//Get all content type
		$content_types = array();
		$content_types = $this->Contenttypemodel->listAll();

		//Meta
		$this->meta->setTitle('Admin - Manages Content Types');

		//render view
		$inner = array();
		$inner['content_types'] = $content_types;

		$page = array();
		$page['contents'] = $this->view->load('content_type/contenttype/listing', $inner, TRUE);
		$this->load->view('themes/' . THEME . '/templates/default', $page);
	}

	function add() {
		$this->load->model('cms/contenttype/Contenttypemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		//Form Validations
		$this->form_validation->set_rules('content_type_name', 'content Type Name', 'trim|required');
		$this->form_validation->set_rules('singular_name', 'Singular Name', 'trim|required');
		$this->form_validation->set_rules('node_type', 'Type', 'trim|required');
		$this->form_validation->set_rules('content_tab', 'Content Tab', 'trim|required');
		$this->form_validation->set_rules('content_type_alias', 'URI Alias', 'trim|strtolower|is_unique[content_type.content_type_alias]');
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		//Meta
		$this->meta->setTitle('Admin - Add Content Type');
		$content_type = array();
		$data = array("" => "Select Type", TYPE_PAGE => "Page", TYPE_NODE_TEXT => "Text Node", TYPE_NODE_WYSIWYG => "WYSIWYG Node");
		//$data = array("" => "Select Type", TYPE_PAGE => "Page", TYPE_NODE_WYSIWYG => "Node");
		foreach ($data as $key => $val) {
			$content_type[$key] = $val;
		}

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$page = array();
			$inner['content_type'] = $content_type;
			$page['contents'] = $this->view->load('content_type/contenttype/add', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Contenttypemodel->insertRecord();

			$this->session->set_flashdata('SUCCESS', 'contenttype_added');

			redirect('content_type/content_type');
			exit();
		}
	}

	//function to edit record
	function edit($ctid = false) {
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('cms/contenttype/Contenttypemodel');

		//Get Page Type Details
		$content_type = array();
		$content_type = $this->Contenttypemodel->fetchById($ctid);
	
		if (!$content_type) {
			$this->http->show404();
			return;
		}

		//Form Validations
		$this->form_validation->set_rules('content_type_name', 'Content Type Name', 'trim|required');
		$this->form_validation->set_rules('singular_name', 'Singular Name', 'trim|required');
		$this->form_validation->set_rules('node_type', 'Type', 'trim|required');
		$this->form_validation->set_rules('content_tab', 'Content Tab', 'trim|required');
		$this->form_validation->set_rules('content_type_alias', 'URI Alias', 'trim|strtolower|callback_valid_alias_e');
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		//Meta
		$this->meta->setTitle('Admin - Edit Content Type');

		$type = array();
		$data = array("" => "-- Select Type --", "1" => "Page", "2" => "Text Node", "3" => "WYSIWYG Node");
		//$data = array("" => "-- Select Type --", "1" => "Page", "3" => "Node");
		foreach ($data as $key => $val) {
			$type[$key] = $val;
		}

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$page = array();
			$inner['content_type'] = $content_type;
			$inner['type'] = $type;
			$page['contents'] = $this->view->load('content_type/contenttype/edit', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Contenttypemodel->updateRecord($content_type);

			$this->session->set_flashdata('SUCCESS', 'contenttype_updated');

			redirect('content_type/content_type');
			exit();
		}
	}

	//function to delete record
	function delete($ctid) {
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('cms/contenttype/Contenttypemodel');

		//Get Page Type Details
		$content_type = array();
		$content_type = $this->Contenttypemodel->fetchById($ctid);
		if (!$content_type) {
			$this->http->show404();
			return;
		}

		$this->Contenttypemodel->deleteRecord($content_type);

		$this->session->set_flashdata('SUCCESS', 'contenttype_deleted');

		redirect("content_type/content_type");
		exit();
	}

}
