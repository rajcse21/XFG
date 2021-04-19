<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Page_section extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->is_admin_protected = TRUE;

		if (!$this->userauth->checkauth()) {
			redirect(base_url());
		}
		if (!$this->userauth->checkResourceAccess('MANAGE_PAGES')) {
			$this->http->accessDenied();
			return;
		}
		$this->load->vars(array('active_menu' => 'content'));
	}

	// ------------------------------ Validation Starts ---------------------------------- //
	// Add Function
	function valid_section_alias($str) {
		$str = url_title(strtolower($str));

		$this->db->where('page_section_alias', $str);
		$this->db->where('page_i18n_id', $this->input->post('page_i18n_id', true));
		$query = $this->db->get('page_section');
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('valid_section_alias', 'This Section Alias Already Exist!');
			return false;
		}
		return true;
	}

	// Edit Function
	function validSectionAlias($str) {
		$str = url_title(strtolower($str));

		$this->db->where('page_section_alias', $str);
		$this->db->where('page_i18n_id', $this->input->post('page_i18n_id', true));
		$this->db->where('page_section_id !=', $this->input->post('page_section_id', true));
		$this->db->from('page_section');
		$block_count = $this->db->count_all_results();
		if ($block_count != 0) {
			$this->form_validation->set_message('validSectionAlias', 'This Section Alias is already being used!');
			return false;
		}
		return true;
	}

	// ------------------------------ Validation Ends ---------------------------------- //

	function index($page_i18n_id = false, $ajax = false, $lang = False) {
		$this->load->model('cms/Pagesectionmodel');
		$this->load->model('cms/Blockmodel');
		$this->load->model('cms/blocktype/Blocktypemodel');
		$this->load->model('cms/Pagemodel');
		$this->load->helper('text');

		$this->meta->setTitle('Manages Page Section - {SITE_NAME}');

		//	$this->assets->addCSS('assets/themes/' . THEME . 'css/pagetree.css', 150);
		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . '/js/jquery.tablednd.0.7.min.js', false, 150);
		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . '/js/website/cms/page-add.js', false, 150);

		$page_details = $this->Pagemodel->fetchById($page_i18n_id);
		if (!$page_details) {
			$this->http->show404();
			return;
		}

		$sections = $this->cmscore->fetchPageSections($page_details['page_i18n_id']);


		$block_types = $this->Blocktypemodel->listAll();

		$inner = array();
		$inner['page_details'] = $page_details;
		$inner['sections'] = $sections;
		$inner['block_types'] = $block_types;

		$page = array();
		$this->load->view('themes/' . THEME . '/modules/cms/pages/page_section/listing', $inner);
	}

	function globalSection($page_i18n_id = false) {
		$this->load->model('cms/Pagesectionmodel');
		$this->load->model('cms/Globalsectionmodel');
		$this->load->model('cms/Pagemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		$page_details = $this->Pagemodel->fetchById($page_i18n_id);
		if (!$page_details) {
			$this->http->show404();
			return;
		}

		$this->meta->setTitle('Add Page Section - {SITE_NAME}');

		$global_sections = $this->Globalsectionmodel->listAll();

		$this->form_validation->set_rules('global_section_id', 'Section', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$inner['page_details'] = $page_details;
			$inner['global_sections'] = $global_sections;
			$page = array();

			$page['contents'] = $this->view->load('cms/pages/page_section/add_global_section', $inner, TRUE);
			$this->load->view("themes/" . THEME . "/templates/popup", $page);
		} else {
			if ($this->input->post('global_section_id', TRUE)) {
				$global_section_id = $this->input->post('global_section_id', TRUE);
				redirect("cms/page-section/add/{$page_details['page_i18n_id']}/{$global_section_id}");
			}
			redirect("cms/page-section/add/{$page_details['page_i18n_id']}");
		}
	}

	function add($page_i18n_id = false, $global_section_id = false) {
		$this->load->model('cms/Pagesectionmodel');
		$this->load->model('cms/Globalsectionmodel');
		$this->load->model('cms/Pagemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		$page_details = $this->Pagemodel->fetchById($page_i18n_id);
		if (!$page_details) {
			$this->http->show404();
			return;
		}

		$section = $this->Pagesectionmodel->fetchById($global_section_id);

		$this->meta->setTitle('Add Page Section - {SITE_NAME}');

		$global_sections = array();
		$global_sections[0] = '-- Select --';
		$rs = $this->Globalsectionmodel->listAll();
		if ($rs) {
			foreach ($rs as $row) {
				$global_sections[$row['global_section_id']] = $row['section_name'];
			}
		}

		//Form Validations
		$this->form_validation->set_rules('page_section', 'Section Name', 'trim|required');

		if ($this->input->post('page_section_alias') && $this->input->post('page_section_alias') != '') {
			$this->form_validation->set_rules('page_section_alias', 'Section Alias', 'trim|required|callback_valid_section_alias');
		} else {
			$this->form_validation->set_rules('page_section_alias', 'Section Alias', 'trim');
		}
		$this->form_validation->set_rules('page_section_class', 'Section Class', 'trim');
		$this->form_validation->set_rules('page_section_background', 'Section Background', 'trim');
		$this->form_validation->set_rules('page_section_img_medium', 'Section Tablet Background', 'trim');
		$this->form_validation->set_rules('page_section_img_small', 'Section Mobile Background', 'trim');

		if ($global_section_id == 0) {
			$this->form_validation->set_rules('page_section_template', 'Section Name Template', 'trim');
			$this->form_validation->set_rules('page_section_block_template', 'Block Template', 'trim');
		}

		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$inner['page_details'] = $page_details;
			$inner['global_sections'] = $global_sections;
			$inner['global_section_id'] = $global_section_id;

			$page = array();
			$page['contents'] = $this->view->load('cms/pages/page_section/add', $inner, TRUE);
			$this->load->view("themes/" . THEME . "/templates/popup", $page);
		} else {
			$this->Pagesectionmodel->insertRecord($page_details['page_i18n_id'], $global_section_id);

			redirect("cms/page-section/added");
		}
	}

	function added() {
		$this->meta->setTitle('Add Page Section - {SITE_NAME}');

		$page = array();
		$page['contents'] = "<input type='hidden' name='page_section_success' class='page_section_success'/><h1>Success</h1><p>Section added successfully!</p>";
		$this->load->view('themes/' . THEME . '/templates/popup', $page);
	}

	//function to edit record
	function edit($sid = false, $lang = false) {
		$this->load->model('cms/Pagesectionmodel');
		$this->load->model('cms/Globalsectionmodel');
		$this->load->model('cms/Pagemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');


		$section = $this->Pagesectionmodel->fetchById($sid);
		if (!$section) {
			$this->http->show404();
			return;
		}

		$page_details = $this->Pagemodel->fetchById($section['page_i18n_id'], $lang);
		if (!$page_details) {
			$this->http->show404();
			return;
		}

		$this->meta->setTitle('Edit Page Section - {SITE_NAME}');

		$global_sections = array();
		$global_sections[0] = '-- Select --';
		$rs = $this->Globalsectionmodel->listAll();
		if ($rs) {
			foreach ($rs as $row) {
				$global_sections[$row['global_section_id']] = $row['section_name'];
			}
		}

		$this->form_validation->set_rules('page_section', 'Section Name', 'trim|required');

		if ($this->input->post('page_section_alias') && $this->input->post('page_section_alias') != '') {
			$this->form_validation->set_rules('page_section_alias', 'Section Alias', 'trim|required|callback_validSectionAlias');
		} else {
			$this->form_validation->set_rules('page_section_alias', 'Section Alias', 'trim');
		}
                $this->form_validation->set_rules('page_section_class', 'Section Class', 'trim');
		$this->form_validation->set_rules('page_section_background', 'Section Background', 'trim');
		$this->form_validation->set_rules('page_section_img_medium', 'Section Tablet Background', 'trim');
		$this->form_validation->set_rules('page_section_img_small', 'Section Mobile Background', 'trim');
		if ($section['global_section_id'] == 0) {
			$this->form_validation->set_rules('page_section_template', 'Section Name Template', 'trim');
			$this->form_validation->set_rules('page_section_block_template', 'Block Template', 'trim');
		}
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$inner['page_details'] = $page_details;
			$inner['global_sections'] = $global_sections;
			$inner['section'] = $section;

			$page = array();
			$page = array();
			$page['contents'] = $this->view->load('cms/pages/page_section/edit', $inner, TRUE);
			$this->load->view("themes/" . THEME . "/templates/popup", $page);
		} else {
			$this->Pagesectionmodel->UpdateRecord($section);
			redirect("cms/page-section/added");
		}
	}

	function delete($sid = false) {
		$this->load->model('cms/Pagesectionmodel');

		$section = $this->Pagesectionmodel->fetchById($sid);
		if (!$section) {
			$this->http->show404();
			return;
		}

		$this->Pagesectionmodel->deleteRecord($section['page_section_id']);
		$this->session->set_flashdata('SUCCESS', 'section_deleted');
		redirect("cms/page/edit/{$section['page_i18n_id']}#tab_content", 'location');
	}

	// Via Ajax
	function isActive($sid = FALSE) {
		$this->load->model('cms/Pagesectionmodel');

		$output = array();
		$output['status'] = 'ERROR';
		$output['message'] = '';

		$section = $this->Pagesectionmodel->fetchById($sid);
		if ($section) {
			$status = $this->Pagesectionmodel->enableDisable($section);
			if ($status) {
				$output['status'] = 'SUCCESS';
			}
		}
		redirect("cms/page/edit/{$section['page_i18n_id']}#tab_content", 'location');
		//$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

}

?>