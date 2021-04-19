<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Template extends CI_Controller {

	function __construct() {
		parent::__construct();

		//Check For User Login
		$user = $this->userauth->checkAuth();
		if (!$user) {
			redirect("user");
		}
		$this->load->vars(array('active_menu' => 'cn_structure'));
	}

	function valid_alias($str) {
		$str = url_title(strtolower($str));

		$this->db->where('template_alias', $str);
		$this->db->from('page_template');
		$templatealias_count = $this->db->count_all_results();
		if ($templatealias_count != 0) {
			$this->form_validation->set_message('valid_alias', 'Template Alias is already being used!');
			return false;
		}
		return true;
	}

	function valid_alias_e($str) {
		$str = url_title(strtolower($str));

		$this->db->where('template_alias', $str);
		$this->db->where('page_template_id !=', $this->input->post('page_template_id', true));
		$this->db->from('page_template');

		$templatealias_count = $this->db->count_all_results();

		if ($templatealias_count != 0) {
			$this->form_validation->set_message('valid_alias_e', 'Template Alias is already being used!');
			return false;
		}
		return true;
	}

	function index($offset = 0) {
		$this->load->model('cms/Templatemodel');
		$this->load->library('pagination');
		$this->load->helper('text');

		//Meta
		$this->meta->setTitle('Admin - Manage Template');

		//Setup pagination
		$perpage = 20;
		$config['base_url'] = base_url() . "cms/template/index";
		$config['uri_segment'] = 4;
		$config['total_rows'] = $this->Templatemodel->countAll();
		$config['per_page'] = $perpage;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['prev_link'] = FALSE;
		$config['next_link'] = FALSE;
		$config['last_link'] = '&raquo;';
		$config['first_link'] = '&laquo;';
		$config['attributes'] = array('class' => 'page-link');
		$this->pagination->initialize($config);

		//List all templates
		$templates = array();
		$templates = $this->Templatemodel->listAll($offset, $perpage);

		//Render view
		$inner = array();
		$inner['templates'] = $templates;
		$inner['pagination'] = $this->pagination->create_links();

		$page = array();
		$page['contents'] = $this->view->load('cms/templates/templates_listing', $inner, TRUE);
		$this->load->view('themes/' . THEME . '/templates/default', $page);
	}

	//Function add templates
	function add() {
		$this->load->model('cms/Templatemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		//Meta
		$this->meta->setTitle('Admin - Add Template');

		//validation check
		$this->form_validation->set_rules('template_name', 'Template Name', 'trim|required');
		$this->form_validation->set_rules('template_alias', 'Template Alias', 'trim|callback_valid_alias');
		$this->form_validation->set_rules('template_path', 'Template Path', 'trim');
		$this->form_validation->set_rules('template_contents', 'Contents', 'trim|required');
		$this->form_validation->set_rules('admin_modules', 'Admin Modules', 'trim');
		$this->form_validation->set_rules('front_modules', ' Frontend Modules', 'trim');
		$this->form_validation->set_rules('template_type', ' Template Type', 'trim');

		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$page = array();
			$page['contents'] = $this->view->load('cms/templates/templates_add', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Templatemodel->insertRecord();
			$this->session->set_flashdata('SUCCESS', 'template_added');
			redirect("cms/template", "location");
			exit();
		}
	}

	//Function edit
	function edit($tid = false) {
		$this->load->model('cms/Templatemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		//Meta
		$this->meta->setTitle('Admin - Edit Template');

		//Get template details
		$template = array();
		$template = $this->Templatemodel->fetchByID($tid);
		if (!$template) {
			$this->http->show404();
			return;
		}

		$template_folder = ROOT_APPPATH . 'application/views/themes/' . THEME . "/templates/";

		if ($template['template_path'] != '') {
			$template_folder = $template_folder . $template['template_path'] . '/';
		}

		$file_path = $template_folder . $template['template_alias'] . '.php';

		$template_contents = $template['template_contents'];
		if (file_exists($file_path)) {
			$template_contents = file_get_contents($file_path);
		}

		//validation check
		$this->form_validation->set_rules('template_name', 'Template Name', 'trim|required');
		$this->form_validation->set_rules('template_alias', 'Template Alias', 'trim|callback_valid_alias_e');
		$this->form_validation->set_rules('template_path', 'Template Path', 'trim');
		$this->form_validation->set_rules('template_contents', 'Contents', 'trim|required');
		$this->form_validation->set_rules('admin_modules', 'Admin Modules', 'trim');
		$this->form_validation->set_rules('front_modules', ' Frontend Modules', 'trim');
		$this->form_validation->set_rules('template_type', ' Template Type', 'trim');

		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$inner['template'] = $template;
			$inner['template_contents'] = $template_contents;

			$page = array();
			$page['contents'] = $this->view->load('cms/templates/templates_edit', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Templatemodel->updateRecord($template);

			$this->session->set_flashdata('SUCCESS', 'template_updated');

			redirect("cms/template", "location");
			exit();
		}
	}

	//Function delete
	function delete($tid = false) {
		$this->load->model('cms/Templatemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		//Get template details
		$template = array();
		$template = $this->Templatemodel->fetchByID($tid);
		if (!$template) {
			$this->http->show404();
			return;
		}

		$this->Templatemodel->deleteRecord($template);
		$this->session->set_flashdata('SUCCESS', 'template_deleted');

		redirect("cms/template", "location");
		exit();
	}

}

?>
