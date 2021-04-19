<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Form extends CI_Controller {

	function __construct() {
		parent::__construct();
		$user = $this->userauth->checkAuth();
		if (!$user) {
			redirect("user");
		}

		$this->load->vars(array('active_menu' => 'misc'));
	}

	function index($offset = false) {
		$this->load->model('Formmodel');
		$this->load->library('pagination');

		$this->meta->setTitle('Admin - Manage Form Request');
		$filter = array();
		/*$offset = false;
		if ($this->input->get()) {
			foreach ($this->input->get() as $key => $value) {
				if ($key == 'per_page') {
					$offset = $value;
					continue;
				}
				$filter[$key] = $value;
			}
		}*/


		//Setup pagination
		$perpage = 30;
		$config['base_url'] = base_url() . "form/index";
		$config['uri_segment'] = 3;
		$config['total_rows'] = $this->Formmodel->countAll($filter);
		$config['per_page'] = $perpage;
		$config['full_tag_open'] = '<ul class="pagination justify-content-center">';
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

		$forms = $this->Formmodel->listAll($offset, $perpage, $filter);

		$inner = array();
		$inner['forms'] = $forms;
		$inner['filter'] = $filter;
		$inner['pagination'] = $this->pagination->create_links();

		$page = array();
		$page['contents'] = $this->view->load('forms/listing', $inner, TRUE);
		$this->load->view("themes/" . THEME . "/templates/default", $page);
	}

	function details($form_id = false) {
		$this->load->model('Formmodel');
		$this->load->helper('download');

		$this->meta->setTitle('Admin - Form Details');

		$form_entry = array();
		$form_entry = $this->Formmodel->fetchById($form_id);


		$inner = array();
		$inner['form_entry'] = $form_entry;
		//$inner['utm_params'] = json_decode($form_entry['form_data'], TRUE);
		$inner['utm_params'] = unserialize(base64_decode($form_entry['form_data']));
		
		$page = array();
		$page['contents'] = $this->view->load('forms/details', $inner, TRUE);
		$this->load->view("themes/" . THEME . "/templates/default", $page);
	}

	function delete($form_id = false) {
		$this->db->where('form_entry_id', $form_id);
		$this->db->delete('form_entry');

		redirect('form');
	}

}

?>