<?php

class Fields extends CI_Controller {

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

	function index($ctid = FALSE, $offset = 0) {
		$this->load->model('cms/contenttype/Fieldmodel');
		$this->load->model('cms/contenttype/Contenttypemodel');
		$this->load->library('pagination');
		$this->load->helper('text');


		//Get Page Type Details
		$content_type = array();
		$content_type = $this->Contenttypemodel->fetchById($ctid);
		if (!$content_type) {
			$this->http->show404();
			return;
		}

		//Setup pagination
		$perpage = 50;
		$config['base_url'] = base_url() . "content_type/fields/index/$ctid/";
		$config['uri_segment'] = 5;
		$config['total_rows'] = $this->Fieldmodel->countAll($ctid);
		$config['per_page'] = $perpage;
		$this->pagination->initialize($config);

		//List all content type fields
		$content_fields = array();
		$content_fields = $this->Fieldmodel->listAll($ctid, $offset, $perpage);

		//Render view
		$inner = array();
		$inner['content_fields'] = $content_fields;
		$inner['content_type'] = $content_type;
		$inner['pagination'] = $this->pagination->create_links();

		//Meta
		$this->meta->setTitle('Admin - Manage Content Fields');

		$page = array();
		$page['content'] = $this->load->view('themes/' . THEME . '/modules/content_type/fields/listing', $inner, TRUE);
		$this->load->view('themes/' . THEME . '/templates/default', $page);
	}

	//Function add templates
	function add($ctid = FALSE) {
		$this->load->model('cms/contenttype/Fieldmodel');
		$this->load->model('taxonomy/Vocabularymodel');

		$this->load->model('cms/contenttype/Fieldtypemodel');
		$this->load->model('cms/contenttype/Contenttypemodel');
		$this->load->model('cms/contenttype/Fieldgroupmodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . '/js/website/cms/block_type.js',false,150);

		//Get Page Type Details
		$content_type = array();
		$content_type = $this->Contenttypemodel->fetchById($ctid);
		if (!$content_type) {
			$this->http->show404();
			return;
		}
		$content_fieldgroups = array();
		$content_fieldgroups[''] = 'Select Field Group';
		$content_fieldgroups['0'] = 'Main';
		$rs = $this->Fieldgroupmodel->listAll($ctid);
		foreach ($rs as $row) {
			$content_fieldgroups[$row['content_fieldgroup_id']] = $row['content_fieldgroup'];
		}

		$field_type = array();
		$field_type[''] = 'Select Field Type';
		$rs = $this->Fieldtypemodel->listAll();
		foreach ($rs as $row) {
			$field_type[$row['field_type_id']] = $row['field_name'];
		}

		//Fetch All Vocabulary
		$vocabularies = array();
		$vocabularies[''] = '-- Select Vocabulary --';
		$vocabularies_rs = $this->Vocabularymodel->listAll();
		if ($vocabularies_rs) {
			foreach ($vocabularies_rs as $row) {
				$vocabularies[$row['vocabulary_id']] = $row['vocabulary'];
			}
		}

		//validation check
		$this->form_validation->set_rules('content_fieldgroup_id', 'Field Group', 'trim|required');
		$this->form_validation->set_rules('field_type', 'Field Type', 'trim|required');
		$this->form_validation->set_rules('field_label', 'Field Label', 'trim|required');
		$this->form_validation->set_rules('field_alias', 'Field Alias', 'trim|required');
		$this->form_validation->set_rules('field_help', 'Help', 'trim');

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		//Meta
		$this->meta->setTitle('Admin - Add Content Fields');

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$inner['content_fieldgroups'] = $content_fieldgroups;
			$inner['content_type'] = $content_type;
			$inner['field_type'] = $field_type;
			$inner['vocabularies'] = $vocabularies;

			$page = array();
			$page['content'] = $this->load->view('themes/' . THEME . '/modules/content_type/fields/add', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Fieldmodel->insertRecord($content_type);

			$this->session->set_flashdata('SUCCESS', 'ct_field_added');

			redirect("content_type/fields/index/$ctid");
			exit();
		}
	}

	//Function edit
	function edit($ct_fid = false) {
		$this->load->model('cms/contenttype/Fieldmodel');
		$this->load->model('cms/contenttype/Fieldtypemodel');
		$this->load->model('cms/contenttype/Contenttypemodel');
		$this->load->model('cms/contenttype/Fieldgroupmodel');
		$this->load->model('taxonomy/Vocabularymodel');
		$this->load->library('form_validation');
		$this->load->helper('form');


		//Get content field details
		$content_field = array();
		$content_field = $this->Fieldmodel->detail($ct_fid);
		if (!$content_field) {
			$this->http->show404();
			return;
		}
		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . '/js/website/cms/block_type.js',false, 150);
		
		//validation check
		$this->form_validation->set_rules('content_fieldgroup_id', 'Field Group', 'trim|required');
		$this->form_validation->set_rules('field_type', 'Field Type', 'trim|required');
		$this->form_validation->set_rules('field_label', 'Field Label', 'trim|required');
		$this->form_validation->set_rules('field_alias', 'Field Alias', 'trim|required');
		$this->form_validation->set_rules('field_help', 'Help', 'trim');

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		//Meta
		$this->meta->setTitle('Admin - Edit Content Fields');

		$content_fieldgroups = array();
		$content_fieldgroups[''] = 'Select Field Group';
		$content_fieldgroups['0'] = 'Main';
		$rs = $this->Fieldgroupmodel->listAll($content_field['content_type_id']);
		foreach ($rs as $row) {
			$content_fieldgroups[$row['content_fieldgroup_id']] = $row['content_fieldgroup'];
		}


		$field_type = array();
		$field_type[''] = 'Select Field Type';
		$rs = $this->Fieldtypemodel->listAll();
		foreach ($rs as $row) {
			$field_type[$row['field_type_id']] = $row['field_name'];
		}
		//Fetch All Vocabulary

		$vocabularies = array();
		$vocabularies[''] = '-- Select Vocabulary --';
		$vocabularies_rs = $this->Vocabularymodel->listAll();
		if ($vocabularies_rs) {
			foreach ($vocabularies_rs as $row) {
				$vocabularies[$row['vocabulary_id']] = $row['vocabulary'];
			}
		}

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$inner['content_fieldgroups'] = $content_fieldgroups;
			$inner['field_type'] = $field_type;
			$inner['content_field'] = $content_field;
			$inner['vocabularies'] = $vocabularies;

			$page = array();
			$page['content'] = $this->load->view('themes/' . THEME . '/modules/content_type/fields/edit', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Fieldmodel->updateRecord($content_field);

			$this->session->set_flashdata('SUCCESS', 'ct_field_updated');

			redirect("content_type/fields/index/{$content_field['content_type_id']}");
			exit();
		}
	}

	//Function delete
	function delete($ct_fid = false) {
		$this->load->model('cms/contenttype/Fieldmodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		//Get content field details
		$content_field = array();
		$content_field = $this->Fieldmodel->detail($ct_fid);
		if (!$content_field) {
			$this->http->show404();
			return;
		}

		$this->Fieldmodel->deleteRecord($content_field);
		$this->session->set_flashdata('SUCCESS', 'ct_field_deleted');

		redirect("content_type/fields/index/{$content_field['content_type_id']}");
		exit();
	}

}

?>
