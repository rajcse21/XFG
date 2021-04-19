<?php

class Stream extends CI_Controller {

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

	function valid_alias($str) {
		$this->db->select('stream_alias');
		$this->db->from('content_stream');
		$this->db->where('content_type_id', $this->input->post('content_type', true));
		$this->db->where('stream_alias', $str);
		$rs = $this->db->get();
		if ($rs && $rs->num_rows() > 0) {
			$this->form_validation->set_message('valid_alias', 'The Alias is already being used.');
			return false;
		}
		return true;
	}

	function valid_alias_e($str) {
		$this->db->where('stream_alias', $str);
		$this->db->where('content_type_id', $this->input->post('content_type', true));
		$this->db->where('content_stream_id !=', $this->input->post('content_stream_id', true));
		$this->db->from('content_stream');
		$page_count = $this->db->count_all_results();
		if ($page_count != 0) {
			$this->form_validation->set_message('valid_alias_e', 'URI Alias is already being used!');
			return false;
		}
		return true;
	}

	//************************************************************ Callback function end**********************

	function index($ctid = FALSE, $offset = 0) {
		$this->load->model('cms/contenttype/Streammodel');
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
		$config['base_url'] = base_url() . "content_type/stream/index/$ctid/";
		$config['uri_segment'] = 5;
		$config['total_rows'] = $this->Streammodel->countAll($ctid);
		$config['per_page'] = $perpage;
		$this->pagination->initialize($config);

		//List all streams
		$streams = array();
		$streams = $this->Streammodel->listAll($ctid, $offset, $perpage);

		//Meta
		$this->meta->setTitle('Admin - Manages Content Streams');
		//Render view
		$inner = array();
		$inner['streams'] = $streams;
		$inner['content_type'] = $content_type;
		$inner['pagination'] = $this->pagination->create_links();

		$page = array();
		$page['content'] = $this->load->view('themes/' . THEME . '/modules/content_type/stream/listing', $inner, TRUE);
		$this->load->view('themes/' . THEME . '/templates/default', $page);
	}

	//Function add
	function add($ctid = FALSE) {
		$this->load->model('cms/contenttype/Streammodel');
		$this->load->model('cms/contenttype/Contenttypemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');


		//Get Page Type Details
		$content_type = array();
		$content_type = $this->Contenttypemodel->fetchById($ctid);
	
		if (!$content_type) {
			$this->http->show404();
			return;
		}


		//Validation check
		$this->form_validation->set_rules('stream_name', 'Stream', 'trim|required');
		$this->form_validation->set_rules('stream_alias', 'URI Alias', 'trim|strtolower|callback_valid_alias');
		$this->form_validation->set_rules('item_per_stream', 'Perpage', 'trim|required|numeric');
		$this->form_validation->set_rules('show_pagination', 'Pagination', 'trim|required');
		$this->form_validation->set_rules('filter_by', 'Filter By', 'trim');
		$this->form_validation->set_rules('item_template', 'Template', 'trim');

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		//Per page
		$per_page = array();
		$per_page[''] = '--Select--';
		for ($i = 1; $i <= 5; $i++) {
			$per_page[$i] = $i;
		}

		//$per_page['5'] = '5';
		$per_page['10'] = '10';
		$per_page['15'] = '15';
		$per_page['20'] = '20';
		$per_page['25'] = '25';
		$per_page['30'] = '30';
		$per_page['35'] = '35';
		$per_page['40'] = '40';
		$per_page['45'] = '45';
		$per_page['50'] = '50';

		//Meta
		$this->meta->setTitle('Admin - Add Content Stream');

		//Assets
		$this->assets->addFooterJSInline('var TEMPLATE ="#item_template";', 100);
		$this->assets->addCSS(base_url() . 'assets/themes/' . THEME . 'js/codemirror/lib/codemirror.css',false, 150);
		$this->assets->addCSS(base_url() . 'assets/themes/' . THEME . 'js/codemirror/mode/css/css.js',false, 150);
		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . 'js/codemirror/lib/codemirror.js',false, 150);
		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . 'js/codemirror/mode/xml/xml.js',false,150);
		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . 'js/codemirror/mode/javascript/javascript.js',false, 150);
		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . 'js/codemirror/mode/htmlmixed/htmlmixed.js',false, 150);
		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . 'js/website/template.js',false, 150);

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$inner['content_type'] = $content_type;
			$inner['per_page'] = $per_page;

			$page = array();
			$page['content'] = $this->load->view('themes/' . THEME . '/modules/content_type/stream/add', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Streammodel->insertRecord($content_type);

			$this->session->set_flashdata('SUCCESS', 'stream_added');

			redirect("content_type/stream/index/$ctid");
			exit();
		}
	}

	//Function edit
	function edit($sid = false) {
		$this->load->model('cms/contenttype/Streammodel');
		$this->load->model('cms/contenttype/Contenttypemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');


		//Get stream details
		$stream = array();
		$stream = $this->Streammodel->detail($sid);
		if (!$stream) {
			$this->http->show404();
			return;
		}

		//validation check
		$this->form_validation->set_rules('stream_name', 'Stream', 'trim|required');
		$this->form_validation->set_rules('stream_alias', 'URI Alias', 'trim|strtolower|callback_valid_alias_e');
		$this->form_validation->set_rules('item_per_stream', 'Perpage', 'trim|required|numeric');
		$this->form_validation->set_rules('show_pagination', 'Pagination', 'trim|required');
		$this->form_validation->set_rules('filter_by', 'Filter By', 'trim');
		$this->form_validation->set_rules('item_template', 'Template', 'trim');

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		//Per page
		$per_page = array();
		$per_page[''] = '--Select--';
		for ($i = 1; $i <= 5; $i++) {
			$per_page[$i] = $i;
		}

		//$per_page['5'] = '5';
		$per_page['10'] = '10';
		$per_page['15'] = '15';
		$per_page['20'] = '20';
		$per_page['25'] = '25';
		$per_page['30'] = '30';
		$per_page['35'] = '35';
		$per_page['40'] = '40';
		$per_page['45'] = '45';
		$per_page['50'] = '50';

		//Meta
		$this->meta->setTitle('Admin - Edit Content Stream');

		//Assets
		$this->assets->addFooterJSInline('var TEMPLATE ="#item_template";', 100);
		$this->assets->addCSS(base_url() . 'assets/themes/' . THEME . 'js/codemirror/lib/codemirror.css',false, 150);
		$this->assets->addCSS(base_url() . 'assets/themes/' . THEME . 'js/codemirror/mode/css/css.js',false, 150);
		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . 'js/codemirror/lib/codemirror.js',false, 150);
		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . 'js/codemirror/mode/xml/xml.js',false, 150);
		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . 'js/codemirror/mode/javascript/javascript.js',false, 150);
		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . 'js/codemirror/mode/htmlmixed/htmlmixed.js',false, 150);
		$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . 'js/website/template.js',false, 150);

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$inner['stream'] = $stream;
			$inner['per_page'] = $per_page;

			$page = array();
			$page['content'] = $this->load->view('themes/' . THEME . '/modules/content_type/stream/edit', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Streammodel->updateRecord($stream);

			$this->session->set_flashdata('SUCCESS', 'stream_updated');

			redirect("content_type/stream/index/{$stream['content_type_id']}");
			exit();
		}
	}

	//Function delete
	function delete($sid = false) {
		$this->load->model('cms/contenttype/Streammodel');
		$this->load->library('form_validation');
		$this->load->helper('form');


		//Get stream details
		$stream = array();
		$stream = $this->Streammodel->detail($sid);
		if (!$stream) {
			$this->http->show404();
			return;
		}

		$this->Streammodel->deleteRecord($stream);
		$this->session->set_flashdata('SUCCESS', 'stream_deleted');

		redirect("content_type/stream/index/{$stream['content_type_id']}");
		exit();
	}

}

?>
