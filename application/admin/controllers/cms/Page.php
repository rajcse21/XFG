<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Page extends CI_Controller {

	function __construct() {
		parent::__construct();
		//Check For User Login
		$user = $this->userauth->checkAuth();
		if (!$user) {
			redirect("user");
		}
			$this->load->vars(array('active_menu' => 'content'));
	}

	//------------- Validation Starts -----------------//

	function valid_pageuri_e($str) {
		$this->db->join('page', 'page.page_id=page_i18n.page_id');
		$this->db->where('page_uri', $str);
		$this->db->where('parent_id', $this->input->post('parent_id', true));
		$this->db->where('page_i18n_id !=', $this->input->post('page_i18n_id', true));
		$this->db->from('page_i18n');
		$page_count = $this->db->count_all_results();
		if ($page_count != 0) {
			$this->form_validation->set_message('valid_pageuri_e', 'Page URI is already being used!');
			return false;
		}
		return true;
	}

	function valid_pageuri($str) {
		$this->load->model('cms/Pagemodel');

		$parent = false;
		$page_uri = $str;
		if ($this->input->post('parent_id', true) > 0) {
			$parent = $this->Pagemodel->fetchById($this->input->post('parent_id', true));
			$page_uri = $parent['page_uri'] . '/' . $str;
		}

		$this->db->join('page', 'page.page_id=page_i18n.page_id');
		$this->db->where('page_uri', $page_uri);
		$this->db->where('parent_id', $this->input->post('parent_id', true));
		$this->db->from('page_i18n');
		$page_count = $this->db->count_all_results();

		if ($page_count != 0) {
			$this->form_validation->set_message('valid_pageuri', 'Page URI is already being used!');
			return false;
		}
		return true;
	}

	//------------- Validation Ends -----------------//

	function index($ctid = 0, $offset = 0) {
		$this->load->model('cms/Pagemodel');
		$this->load->model('cms/contenttype/Contenttypemodel');
		$this->load->helper('text');

		//	$this->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/jquery.tablednd.0.7.min.js'));
		//	$this->JS->add(new Assetic\Asset\FileAsset(ASSETS_PATH . '/js/website/cms/page.js'));
		//get content type
		$content_type = $this->Contenttypemodel->fetchbyId($ctid);

		if (!$content_type) {
			$this->http->show404();
			return;
		}

		//Meta
		$this->meta->setTitle('Manages Pages - {SITE_NAME}');

		//Get all pages
		$pages = $this->Pagemodel->listAll($content_type['content_type_id']);

		//render view
		$inner = array();
		$inner['pages'] = $pages;
		$inner['content_type'] = $content_type;

		$shell = array();
		$shell['contents'] = $this->view->load("cms/pages/listing", $inner, TRUE);
		$this->load->view("themes/" . THEME . "/templates/default", $shell);
	}

	function add($ctid = 0) {
		//$this->load->model('Lucenemodel');
		$this->load->model('cms/Pagemodel');
		$this->load->model('cms/Languagemodel');
		$this->load->model('cms/contenttype/Fieldgroupmodel');
		$this->load->model('cms/contenttype/Fieldmodel');
		$this->load->model('cms/contenttype/Contenttypemodel');
		$this->load->model('cms/Templatemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');


		//get content type
		$content_type = $this->Contenttypemodel->fetchById($ctid);
		if (!$content_type) {
			$this->http->show404();
			return;
		}

		$additional_tabs = array();
		$additional_tabs = $this->Fieldgroupmodel->listAll($content_type['content_type_id']);


		$additional_fields = array();
		$additional_fields = $this->Fieldmodel->listGroupFields($content_type['content_type_id'], 0);



		$languages = $this->Languagemodel->getAllLanguages('language_code');
		$lang = config_item('DEFAULT_LANG');
		if ($this->input->get('lang', TRUE) && in_array($this->input->get('lang', TRUE), $languages)) {
			$lang = strtolower(trim($this->input->get('lang', TRUE)));
		}

		$this->meta->setTitle('Add Page - {SITE_NAME}');

		//Assets
		//	$this->assets->addCSS(base_url() . 'assets/themes/' . THEME . '/js/fancybox/jquery.fancybox.css', false, 150);
		//	$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . '/js/fancybox/jquery.fancybox.pack.js', false, 150);
		//	$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . '/js/website/cms/page-add.js', false, 150);
		//fetch the old page for parent
		$parent = array();
		$parent['0'] = 'Root';
		$pages = $this->Pagemodel->listAll($content_type['content_type_id'], 0);
		foreach ($pages as $row) {
			$parent[$row['page_id']] = str_repeat('&nbsp;', ($row['page_level']) * 8) . $row['page_name'];
		}

		if ($content_type['node_type'] != TYPE_PAGE) {
			$this->form_validation->set_rules('page_name', $content_type["singular_name"] . '&nbsp Name', 'trim|required');
			$this->form_validation->set_rules('page_title', $content_type["singular_name"] . '&nbspTitle', 'trim|required');
		} else {
			$this->form_validation->set_rules('page_name', 'Page Name', 'trim|required');
			$this->form_validation->set_rules('page_title', 'Page Heading', 'trim|required');
			$this->form_validation->set_rules('page_template_id', 'Template', 'trim|required');
		}
		$this->form_validation->set_rules('page_status', 'Page Status', 'trim|required');
		$this->form_validation->set_rules('parent_id', 'Parent', 'trim');
		$this->form_validation->set_rules('browser_title', 'Browser Title', 'trim');
		$this->form_validation->set_rules('page_uri', 'Page URI', 'trim|strtolower|callback_valid_pageuri');

		$this->form_validation->set_rules('include_in_site_map', 'Include In Site Map', 'trim');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'trim');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'trim');
		$this->form_validation->set_rules('before_head_close', 'Addtional Header Contents', 'trim');
		$this->form_validation->set_rules('before_body_close', 'Addtional Footer Contents', 'trim');
		$this->form_validation->set_rules('enable_page_cache', 'Enable Page Cache', 'trim');
		$this->form_validation->set_rules('cache_for', 'Cache For', 'trim');

		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		//Fetch the page templates
		$page_templates = array();
		$page_templates[''] = '-- Select --';
		$rs = $this->Templatemodel->listAll();
		foreach ($rs as $item) {
			$page_templates[$item['page_template_id']] = $item['template_name'];
		}

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$inner['parent'] = $parent;
			$inner['page_templates'] = $page_templates;
			$inner['content_type'] = $content_type;
			$inner['additional_tabs'] = $additional_tabs;
			$inner['additional_fields'] = $additional_fields;


			$page = array();
			switch ($content_type['node_type']) {
				case TYPE_PAGE:
					$page['contents'] = $this->view->load('cms/pages/page_add', $inner, TRUE);
					break;
				case TYPE_NODE_TEXT:
					$page['contents'] = $this->view->load('cms/pages/text_add', $inner, TRUE);
					break;
				case TYPE_NODE_WYSIWYG:
					$page['contents'] = $this->view->load('cms/pages/wysiwyg_add', $inner, TRUE);
					break;
			}

			$this->load->view("themes/" . THEME . "/templates/default", $page);
		} else {

			$page_i18n_id = $this->Pagemodel->insertRecord($content_type, $additional_fields, $additional_tabs);
			if (!$page_i18n_id) {
				show_error('The system encountered an error while adding the page. Please try again.');
				return FALSE;
			}

			$this->session->set_flashdata('SUCCESS', 'page_added');
			redirect('cms/page/index/' . $content_type['content_type_id']);
			exit();
		}
	}

	function edit($pid = false, $lang = False) {
		//$this->load->model('Lucenemodel');
		$this->load->model('cms/Pagemodel');
		$this->load->model('cms/Pagesectionmodel');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('cms/Pagemodel');
		$this->load->model('cms/contenttype/Fieldgroupmodel');
		$this->load->model('cms/contenttype/Fieldmodel');
		$this->load->model('cms/Templatemodel');
		//$this->load->model('includes/Includemodel');


		$this->meta->setTitle('Edit Page - {SITE_NAME}');
		

		//Get Page Details
		$page_details = $this->Pagemodel->fetchById($pid, $lang);
		if (!$page_details) {
			$this->http->show404();
			return;
		}

		//Additional Fields
		$additional_fields = $this->Fieldmodel->listGroupFields($page_details['content_type_id'], 0);
		$additional_tabs = $this->Fieldgroupmodel->listAll($page_details['content_type_id']);
		$content_data = $this->Pagemodel->getAdditionalFieldData($page_details['page_i18n_id']);



		//fetch the old page for parent
		$parent = array();
		$parent['0'] = 'Root';
		$pages = $this->Pagemodel->listAll($page_details['content_type_id'], 0);
		foreach ($pages as $row) {
			if ($row['page_id'] == $page_details['page_id']) {
				continue;
			}
			$parent[$row['page_id']] = str_repeat('&nbsp;', ($row['page_level']) * 8) . $row['page_title'];
		}
		$sections = $this->Pagesectionmodel->fetchPageSections($page_details['page_i18n_id']);


//Fetch Includes
		$page_includes = array();
		/*$this->db->where('page_id', $page_details['page_id']);
		$rs = $this->db->get('page_include');
		//$includes_rs = $this->Includemodel->getIncludesByPage($page_details['page_id']);
		foreach ($rs->result_array() as $item) {
			$page_includes[] = $item['include_id'];
		}*/

		$includes = array();
		/*$includes_rs = $this->Includemodel->getPageIncludes();
		foreach ($includes_rs as $page_include) {
			$includes[$page_include['include_location']][] = $page_include;
		}*/


		//Form Validations
		if ($page_details['node_type'] != TYPE_PAGE) {
			$this->form_validation->set_rules('page_name', $page_details["singular_name"] . ' Name', 'trim|required');
			$this->form_validation->set_rules('page_title', $page_details["singular_name"] . ' Title', 'trim|required');
		} else {
			$this->form_validation->set_rules('page_name', 'Page Name', 'trim|required');
			$this->form_validation->set_rules('page_title', 'Page Title', 'trim|required');
			$this->form_validation->set_rules('page_template_id', 'Template', 'trim|required');
		}
		$this->form_validation->set_rules('page_status', 'Page Status', 'trim|required');
		$this->form_validation->set_rules('parent_id', 'Parent', 'trim');
		$this->form_validation->set_rules('browser_title', 'Browser Title', 'trim');
		$this->form_validation->set_rules('page_uri', 'Page URI', 'trim|strtolower|callback_valid_pageuri_e');

		$this->form_validation->set_rules('include_in_site_map', 'Include In Site Map', 'trim');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'trim');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'trim');
		$this->form_validation->set_rules('before_head_close', 'Addtional Header Contents', 'trim');
		$this->form_validation->set_rules('before_body_close', 'Addtional Footer Contents', 'trim');
		$this->form_validation->set_rules('enable_page_cache', 'Enable Page Cache', 'trim');
		$this->form_validation->set_rules('cache_for', 'Cache For', 'trim');

		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		//fetch the templates form table
		$page_template = array();
		$page_template[''] = '-- Select --';
		$rs = $this->Templatemodel->listAll();
		foreach ($rs as $item) {
			$page_template[$item['page_template_id']] = $item['template_name'];
		}

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$page = array();
			$inner['page_details'] = $page_details;
			$inner['page_template'] = $page_template;
			$inner['sections'] = $sections;
			$inner['frontend_header'] = true;
			$inner['parent'] = $parent;
			$inner['content_data'] = $content_data;
			$inner['additional_tabs'] = $additional_tabs;
			$inner['additional_fields'] = $additional_fields;
			$inner['includes'] = $includes;
			$inner['page_includes'] = $page_includes;

			switch ($page_details['node_type']) {
				case TYPE_PAGE:
					$page['contents'] = $this->view->load('cms/pages/page_edit', $inner, TRUE);
					break;
				case TYPE_NODE_TEXT:
					$page['contents'] = $this->view->load('cms/pages/text_edit', $inner, TRUE);
					break;
				case TYPE_NODE_WYSIWYG:
					$page['contents'] = $this->view->load('cms/pages/wysiwyg_edit', $inner, TRUE);
					break;
			}

			$this->load->view("themes/" . THEME . "/templates/default", $page);
		} else {
			$this->Pagemodel->updateRecord($page_details, $additional_fields, $additional_tabs);

			$this->session->set_flashdata('SUCCESS', 'page_updated');
			redirect('cms/page/index/' . $page_details['content_type_id']);
			exit();
		}
	}

	function delete($pid = false) {
		//$this->load->model('Lucenemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('cms/Pagemodel');
		
		//Get Page Details
		$page_details = $this->Pagemodel->fetchById($pid);
		if (!$page_details) {
			$this->http->show404();
			return;
		}
		$this->Pagemodel->deleteRecord($page_details);
		$this->session->set_flashdata('SUCCESS', 'page_deleted');
		redirect('cms/page/index/' . $page_details['content_type_id'], 'location');
		exit();
	}

	//Function enable include
	function enable_include($pid = false, $iid = false, $target = FALSE) {
		$this->load->model('cms/Pagemodel');
		//$this->load->model('includes/Includemodel');
	
		//Get Page Details
		$page_details = array();
		$page_details = $this->Pagemodel->fetchById($pid);
		if (!$page_details) {
			$this->http->show404();
			return;
		}

		//fetch the include
		$include = array();
		/*$include = $this->Includemodel->getdetails($iid);
		if (!$include) {
			$this->http->show404();
			return;
		}*/

		//$this->Pagemodel->enableInclude($page_details, $include);

		$this->session->set_flashdata('SUCCESS', 'page_updated');

		redirect("cms/page/edit/$pid");
		exit();
	}

	//Function disable include
	function disable_include($pid = false, $iid = false, $target = FALSE) {
		$this->load->model('cms/Pagemodel');
		//$this->load->model('includes/Includemodel');

		//Get Page Details
		$page_details = array();
		$page_details = $this->Pagemodel->fetchById($pid);
		if (!$page_details) {
			$this->http->show404();
			return;
		}

		//fetch the include
		$include = array();
		/*$include = $this->Includemodel->getdetails($iid);
		if (!$include) {
			$this->http->show404();
			return;
		}*/
		//$this->Pagemodel->disableInclude($page_details, $include);

		$this->session->set_flashdata('SUCCESS', 'page_updated');

		redirect("cms/page/edit/$pid");
		exit();
	}

}

?>