<?php

class Fieldgroup extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->is_admin_protected = TRUE;

		if (!$this->adminuserauth->checkauth()) {
			redirect(base_url());
		}
		if (!$this->adminuserauth->checkResourceAccess('MANAGE_CONTENT_STRUCTURE')) {
			$this->http->accessDenied();
			return;
		}
                
                $this->load->vars(array('active_menu' => 'cn_structure'));
	}

	function index($ptid = FALSE, $offset = 0) {
		$this->load->model('cms/contenttype/Fieldgroupmodel');
		$this->load->model('cms/contenttype/Contenttypemodel');
		$this->load->library('pagination');
		$this->load->helper('text');


		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . '/js/jquery.tablednd.0.7.min.js',false, 150);
		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . '/js/website/fieldgroup.js',false, 150);
		
		//Get Page Type Details
		$content_type = array();
		$content_type = $this->Contenttypemodel->fetchById($ptid);
		if (!$content_type) {
			$this->http->show404();
			return;
		}

		//Setup pagination
		$perpage = 50;
		$config['base_url'] = base_url() . "cms/contenttype/fieldgroup/index/$ptid/";
		$config['uri_segment'] = 5;
		$config['total_rows'] = $this->Fieldgroupmodel->countAll($ptid);
		$config['per_page'] = $perpage;
		$this->pagination->initialize($config);

		//List all page type fields
		$fieldgroups = array();
		$fieldgroups = $this->Fieldgroupmodel->listAll($ptid, $offset, $perpage);

		//Meta
		$this->meta->setTitle('Admin - Manage Content Field Group');
		$this->assets->addCSS(base_url() . 'assets/themes/' . THEME . 'css/pagetree.css',false, 150);

		//Render view
		$inner = array();
		$inner['fieldgroups'] = $fieldgroups;
		$inner['content_type'] = $content_type;
		$inner['pagination'] = $this->pagination->create_links();

		$page = array();
		$page['content'] = $this->load->view('themes/' . THEME . '/modules/content_type/fieldgroups/listing', $inner, TRUE);
		$this->load->view('themes/' . THEME . '/templates/default', $page);
	}

	//Function add templates
	function add($ptid = FALSE) {
		$this->load->model('cms/contenttype/Fieldgroupmodel');
		$this->load->model('cms/contenttype/Contenttypemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');


		//Get Page Type Details
		$content_type = array();
		$content_type = $this->Contenttypemodel->fetchById($ptid);
		if (!$content_type) {
			$this->http->show404();
			return;
		}


		//validation check
		$this->form_validation->set_rules('fieldgroup', 'Field Group', 'trim|required');

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		//Meta
		$this->meta->setTitle('Admin - Add Content Field Group');

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$inner['content_type'] = $content_type;

			$page = array();
			$page['content'] = $this->load->view('themes/' . THEME . '/modules/content_type/fieldgroups/add', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Fieldgroupmodel->insertRecord($content_type);

			$this->session->set_flashdata('SUCCESS', 'fieldgroup_added');

			redirect("content_type/fieldgroup/index/$ptid");
			exit();
		}
	}

	//Function edit
	function edit($gid = false) {
		$this->load->model('cms/contenttype/Fieldgroupmodel');
		$this->load->library('form_validation');
		$this->load->helper('form');


		//Get field group field details
		$fieldgroup = array();
		$fieldgroup = $this->Fieldgroupmodel->detail($gid);
		if (!$fieldgroup) {
			$this->http->show404();
			return;
		}

		//validation check
		$this->form_validation->set_rules('fieldgroup', 'Field Group', 'trim|required');

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		//Meta
		$this->meta->setTitle('Admin - Edit Content Field Group');

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$inner['fieldgroup'] = $fieldgroup;

			$page = array();
			$page['content'] = $this->load->view('themes/' . THEME . '/modules/content_type/fieldgroups/edit', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Fieldgroupmodel->updateRecord($fieldgroup);

			$this->session->set_flashdata('SUCCESS', 'fieldgroup_updated');

			redirect("content_type/fieldgroup/index/{$fieldgroup['content_type_id']}");
			exit();
		}
	}

	//Function delete
	function delete($gid = false) {
		$this->load->model('cms/contenttype/Fieldgroupmodel');

		//Get field group field details
		$fieldgroup = array();
		$fieldgroup = $this->Fieldgroupmodel->detail($gid);
		if (!$fieldgroup) {
			$this->http->show404();
			return;
		}

		$this->Fieldgroupmodel->deleteRecord($fieldgroup);
		$this->session->set_flashdata('SUCCESS', 'fieldgroup_deleted');

		redirect("content_type/fieldgroup/index/{$fieldgroup['content_type_id']}");
		exit();
	}

}

?>
