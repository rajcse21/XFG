<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Globalsection extends CI_Controller {

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
	function valid_section_alias($str) {
		$str = url_title(strtolower($str));

		$this->db->where('section_alias', $str);
		$query = $this->db->get('global_section');
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('valid_section_alias', 'This Section Alias Already Exist!');
			return false;
		}
		return true;
	}

	//Edit Function
	function validSectionAlias($str) {
		$str = url_title(strtolower($str));

		$this->db->where('section_alias', $str);
		$this->db->where('global_section_id !=', $this->input->post('global_section_id', true));
		$this->db->from('global_section');
		$section_count = $this->db->count_all_results();

		if ($section_count != 0) {
			$this->form_validation->set_message('validSectionAlias', 'This Section Alias is already being used!');
			return false;
		}
		return true;
	}

	//-------------------------------------- Valiadtion Ends ------------------------------------------//

	function index($offset = false) {
		$this->load->model('cms/Globalsectionmodel');
		$this->load->library('pagination');

		$this->meta->setTitle('Manage Global Section - {SITE_NAME}');

		//Setup pagination
		$perpage = 30;
		$config['base_url'] = base_url() . "cms/globalsection/index";
		$config['uri_segment'] = 4;
		$config['total_rows'] = $this->Globalsectionmodel->countAll();
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
		$config['reuse_query_string'] = FALSE;
		$config['page_query_string'] = FALSE;
		$this->pagination->initialize($config);

		$global_sections = $this->Globalsectionmodel->listAll($offset, $perpage);

		//Render View
		$inner = ['global_sections' => $global_sections, 'pagination' => $this->pagination->create_links()];

		$shell = array();
		$shell['contents'] = $this->view->load("cms/globalsection/listing", $inner, TRUE);
		$this->load->view("themes/" . THEME . "/templates/default", $shell);
	}

	function add() {
		$this->load->model('cms/Globalsectionmodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		$this->meta->setTitle('Add Global Section - {SITE_NAME}');

		$this->form_validation->set_rules('section_name', 'Section Name', 'trim|required');
		if ($this->input->post('section_alias') && $this->input->post('section_alias') != '') {
			$this->form_validation->set_rules('section_alias', 'Section Alias', 'trim|callback_valid_section_alias');
		} else {
			$this->form_validation->set_rules('section_alias', 'Section Alias', 'trim');
		}
		$this->form_validation->set_rules('section_template', 'Section Template', 'trim');
		$this->form_validation->set_rules('section_background', 'Section Background', 'trim');
		$this->form_validation->set_rules('section_img_medium', 'Section Tablet Background', 'trim');
		$this->form_validation->set_rules('section_img_small', 'Section Mobile Background', 'trim');
		$this->form_validation->set_rules('section_block_template', 'Block Template', 'trim');
		$this->form_validation->set_rules('section_icon', 'Icon', 'trim');
		$this->form_validation->set_rules('section_category', 'Section Category', 'trim');
		$this->form_validation->set_rules('section_desc', 'Columns', 'trim');
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			//Render View
			$inner = $shell = array();

			$shell['contents'] = $this->view->load("cms/globalsection/add", $inner, TRUE);
			$this->load->view("themes/" . THEME . "/templates/default", $shell);
		} else {
			$this->Globalsectionmodel->insert();
			$this->session->set_flashdata('SUCCESS', 'globalsection_added');

			redirect("cms/globalsection/index/", "location");
		}
	}

	function edit($sid = FALSE) {
		$this->load->model('cms/Globalsectionmodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		$this->meta->setTitle('Edit Global Section - {SITE_NAME}');

		$section = $this->Globalsectionmodel->fetchById($sid);
		if (!$section) {
			$this->http->show404();
			return;
		}

		$this->form_validation->set_rules('section_name', 'Section Name', 'trim|required');
		if ($this->input->post('section_alias') && $this->input->post('section_alias') != '') {
			$this->form_validation->set_rules('section_alias', 'Section Alias', 'trim|callback_validSectionAlias');
		} else {
			$this->form_validation->set_rules('section_alias', 'Section Alias', 'trim');
		}
		$this->form_validation->set_rules('section_template', 'Section Template', 'trim');
		$this->form_validation->set_rules('section_background', 'Section Background', 'trim');
		$this->form_validation->set_rules('section_img_medium', 'Section Tablet Background', 'trim');
		$this->form_validation->set_rules('section_img_small', 'Section Mobile Background', 'trim');
		$this->form_validation->set_rules('section_block_template', 'Block Template', 'trim');
		$this->form_validation->set_rules('section_icon', 'Icon', 'trim');
		$this->form_validation->set_rules('section_category', 'Section Category', 'trim');
		$this->form_validation->set_rules('section_desc', 'Columns', 'trim');
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			//Render View
			$inner = ['section' => $section];
			$shell = array();

			$shell['contents'] = $this->view->load("cms/globalsection/edit", $inner, TRUE);
			$this->load->view("themes/" . THEME . "/templates/default", $shell);
		} else {
			$this->Globalsectionmodel->update($section['global_section_id']);
			$this->session->set_flashdata('SUCCESS', 'section_updated');

			redirect("cms/globalsection/index");
		}
	}

	function delete($sid = false) {
		$this->load->model('cms/Globalsectionmodel');
		$this->load->model('cms/Globalblockmodel');

		$section = $this->Globalsectionmodel->fetchById($sid);
		if (!$section) {
			$this->http->show404();
			return;
		}


		$this->Globalsectionmodel->delete($section['global_section_id']);

		$this->session->set_flashdata('SUCCESS', 'globalsection_deleted');
		redirect("cms/globalsection/index/", "location");
	}

}

?>