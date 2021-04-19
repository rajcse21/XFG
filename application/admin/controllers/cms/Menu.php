<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Menu extends CI_Controller {

	function __construct() {
		parent::__construct();

		if (!$this->userauth->checkauth()) {
			redirect(base_url());
		}
		if (!$this->userauth->checkResourceAccess('MANAGE_CONTENT_STRUCTURE')) {
			$this->http->accessDenied();
			return;
		}

		$this->load->vars(array('active_menu' => 'content'));
	}

	//----------------------------------- Validation Starts ---------------------------------------------//

	function valid_alias($str) {
		$str = url_title(strtolower($str));

		$this->db->where('menu_alias', $str);
		$this->db->from('menu');
		$block_count = $this->db->count_all_results();
		if ($block_count != 0) {
			$this->form_validation->set_message('valid_alias', 'Menu Alias is already being used!');
			return FALSE;
		}
		return TRUE;
	}

	function valid_alias_e($str) {
		$str = url_title(strtolower($str));

		$this->db->where('menu_alias', $str);
		$this->db->where('menu_id !=', $this->input->post('menu_id', true));
		$this->db->from('menu');
		$block_count = $this->db->count_all_results();
		if ($block_count != 0) {
			$this->form_validation->set_message('valid_alias_e', 'Menu Alias is already being used!');
			return false;
		}
		return true;
	}

	//----------------------------------- Validation Ends ---------------------------------------------//

	function index($offset = 0) {
		$this->load->model('cms/Menumodel');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->library('pagination');


		//Setup pagination
		$perpage = 20;
		$config['base_url'] = base_url() . "cms/menu/index";
		$config['uri_segment'] = 4;
		$config['total_rows'] = $this->Menumodel->countAll();
		$config['per_page'] = $perpage;
		$config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_tag_open'] = '<li class="arrow">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="arrow">';
		$config['last_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['prev_link'] = FALSE;
		$config['next_link'] = FALSE;
		$config['last_link'] = '&raquo;';
		$config['first_link'] = '&laquo;';
		$this->pagination->initialize($config);

		$this->meta->setTitle('Admin - Manage Menus');

		$menu = $this->Menumodel->listAll($offset, $perpage);

		//Render view
		$inner = $page = array();
		$inner['menu'] = $menu;
		$inner['pagination'] = $this->pagination->create_links();

		$page['contents'] = $this->view->load('cms/menus/menu-index', $inner, TRUE);
		$this->load->view('themes/' . THEME . '/templates/default', $page);
	}

	function add() {
		$this->load->model('cms/Menumodel');
		$this->load->library('form_validation');
		$this->load->helper('form');


		$this->meta->setTitle('Admin - Menu Add');

		$this->form_validation->set_rules('menu_title', 'Menu Title', 'trim');
		$this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required');
		$this->form_validation->set_rules('menu_link', 'Menu Link', 'trim');
		$this->form_validation->set_rules('menu_alias', 'Menu Alias', 'trim|required|callback_valid_alias');
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			$inner = $page = array();

			$page['contents'] = $this->view->load('/cms/menus/menu-add', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Menumodel->insertRecord();

			$this->session->set_flashdata('SUCCESS', 'menu_added');
			redirect('cms/menu/index', 'location');
			exit();
		}
	}

	function edit($mid = FALSE) {
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('cms/Menumodel');

		$menu = $this->Menumodel->fetchById($mid);
		if (!$menu) {
			$this->http->show404();
			return;
		}

		$this->meta->setTitle('Admin - Menu Edit');

		//Form Validations
		$this->form_validation->set_rules('menu_title', 'Menu Title', 'trim');
		$this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required');
		$this->form_validation->set_rules('menu_link', 'Menu Link', 'trim');
		$this->form_validation->set_rules('menu_alias', 'Menu Alias', 'trim|required|callback_valid_alias_e');
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			$inner = $page = array();
			$inner['menu'] = $menu;

			$page['contents'] = $this->view->load('cms/menus/menu-edit', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Menumodel->updateRecord($menu['menu_id']);

			$this->session->set_flashdata('SUCCESS', 'menu_updated');
			redirect('cms/menu/index', 'location');
			exit();
		}
	}

	function delete($mid = FALSE) {
		$this->load->model('cms/Menumodel');

		$menu = $this->Menumodel->fetchById($mid);
		if (!$menu) {
			$this->http->show404();
			return;
		}

		$this->Menumodel->deleteRecord($menu['menu_id']);
		$this->session->set_flashdata('SUCCESS', 'menu_deleted');
		redirect("cms/menu/index/");
		exit();
	}

}

?>