<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Menu_item extends CI_Controller {

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

	function index($mid = FALSE) {
		$this->load->model('cms/Menulinkmodel');
		$this->load->model('cms/Menumodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		$menu_detail = $this->Menumodel->fetchById($mid);
		if (!$menu_detail) {
			$this->http->show404();
			return;
		}
		$this->meta->setTitle('Admin - Manage Menus Items');

		//Fetch pagetree
		$menutree = '';
		$menutree = $this->Menulinkmodel->menuItemTree($menu_detail['menu_id']);

	//	$this->assets->addCSS(base_url() . 'assets/themes/' . THEME . '/css/pagetree.css', false, 150);
	//	$this->assets->addFooterJS(base_url() . 'assets/themes/' . THEME . '/js/website/cms/menu.js', false, 150);

		$menu_items = $this->Menulinkmodel->getAll($menu_detail['menu_id']);

		//render view
		$inner = array();
		$inner['menu_items'] = $menu_items;
		$inner['menu_detail'] = $menu_detail;
		$inner['menutree'] = $menutree;

		$page = array();
		$page['contents'] = $this->view->load('cms/menus/menu_items/listing', $inner, TRUE);
		$this->load->view('themes/' . THEME . '/templates/default', $page);
	}

	//function add
	function add($mid = false) {
		$this->load->model('cms/Menulinkmodel');
		$this->load->model('cms/Menumodel');
		$this->load->model('cms/Pagemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		$menu_detail = $this->Menumodel->fetchById($mid);
		if (!$menu_detail) {
			$this->http->show404();
			return;
		}
		$this->meta->setTitle('Admin - Add Menus Item');

		//fetch the menu item  indentedList
		$parent_menu = array();
		$parent_menu['0'] = 'Root';
		$rs = $this->Menulinkmodel->indentedList($menu_detail['menu_id']);
		foreach ($rs as $row) {
			$parent_menu[$row['menu_item_id']] = str_repeat('&nbsp;', ($row['menu_item_level']) * 8) . $row['menu_item_name'];
		}

		//fetch the main page
		$pages = array();
		$pages[''] = 'Select';
		$rs = $this->Pagemodel->allPagesAsArray(1, 0);

		foreach ($rs as $row) {
			$pages[$row['page_id']] = str_repeat('&nbsp;', ($row['page_level']) * 8) . $row['page_title'];
		}

		//Menu item types
		$menu_item_types = array();
		$menu_item_types[''] = 'Select';
		$menu_item_types['page'] = 'Page';
		$menu_item_types['url'] = 'URL';
		$menu_item_types['placeholder'] = 'Placeholder';

		//Form Validations
		$this->form_validation->set_rules('parent_id', 'Parent Name', 'trim');
		$this->form_validation->set_rules('menu_item_name', 'Menu Item Name', 'trim|required');
		$this->form_validation->set_rules('menu_item_identifier', 'Menu Identifier', 'trim');
		$this->form_validation->set_rules('menu_item_icon', 'Icon', 'trim');
		$this->form_validation->set_rules('menu_item_class', 'CSS Class Name', 'trim');
		switch ($this->input->post('menu_item_type', TRUE)) {
			case "page":
				$this->form_validation->set_rules('content_id', 'Page', 'trim|required');
				break;
			case "url":
				$this->form_validation->set_rules('url', 'URL', 'trim|required');
				$this->form_validation->set_rules('new_window', 'New Window', 'trim');
				break;
		}


		$this->meta->setTitle('Admin - Add Menus Items');

		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$shell = array();

			$inner['parent_menu'] = $parent_menu;
			$inner['pages'] = $pages;
			$inner['menu_detail'] = $menu_detail;
			$inner['menu_item_types'] = $menu_item_types;

			$page['contents'] = $this->view->load('cms/menus/menu_items/add', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Menulinkmodel->insertRecord($menu_detail['menu_id']);

			$this->session->set_flashdata('SUCCESS', 'menu_item_added');
			redirect("cms/menu_item/index/{$menu_detail['menu_id']}", 'location');
			exit();
		}
	}

	function edit($m_item_id = false) {
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('cms/Menulinkmodel');
		$this->load->model('cms/Pagemodel');


		$menu_item = $this->Menulinkmodel->fetchById($m_item_id);
		if (!$menu_item) {
			$this->http->show404();
			return;
		}

		$this->meta->setTitle('Admin - Edit Menus Item');

		//fetc the menu item  indentedList
		$parent_menu = array();
		$parent_menu['0'] = 'Root';
		$rs = $this->Menulinkmodel->indentedList($menu_item['menu_id'], $menu_item['menu_item_id']);
		foreach ($rs as $row) {
			$parent_menu[$row['menu_item_id']] = str_repeat('&nbsp;', ($row['menu_item_level']) * 8) . $row['menu_item_name'];
		}


		//fetch the main page
		$pages = array();
		$pages[''] = 'Select';
		$rs = $this->Pagemodel->allPagesAsArray(1, 0);
		foreach ($rs as $row) {
			$pages[$row['page_id']] = str_repeat('&nbsp;', ($row['page_level']) * 8) . $row['page_title'];
		}

		//Menu item types
		$menu_item_types = array();
		$menu_item_types[''] = 'Select';
		$menu_item_types['page'] = 'Page';
		$menu_item_types['url'] = 'URL';
		$menu_item_types['placeholder'] = 'Placeholder';

		//Form validation
		$this->form_validation->set_rules('parent_id', 'Parent Name', 'trim|required');
		$this->form_validation->set_rules('menu_item_type', 'Menu Type ', 'trim|required');
		$this->form_validation->set_rules('menu_item_name', 'Link Name', 'trim|required');
		$this->form_validation->set_rules('menu_item_identifier', 'Menu Identifier', 'trim');
		$this->form_validation->set_rules('menu_item_icon', 'Icon', 'trim');
		$this->form_validation->set_rules('new_window', 'New Window', 'trim');
		$this->form_validation->set_rules('menu_item_class', 'CSS Class Name', 'trim');


		switch ($this->input->post('menu_item_type', TRUE)) {
			case "page":
				$this->form_validation->set_rules('content_id', 'Page', 'trim|required');
				break;
			case "url":
				$this->form_validation->set_rules('url', 'URL', 'trim|required');
				break;
		}

		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$page = array();
			$inner['menu_item'] = $menu_item;
			$inner['parent_menu'] = $parent_menu;
			$inner['pages'] = $pages;
			$inner['menu_item_types'] = $menu_item_types;

			$page['contents'] = $this->view->load('cms/menus/menu_items/edit', $inner, TRUE);
			$this->load->view('themes/' . THEME . '/templates/default', $page);
		} else {
			$this->Menulinkmodel->updateRecord($menu_item);

			$this->session->set_flashdata('SUCCESS', 'menu_item_updated');

			redirect("cms/menu_item/index/{$menu_item['menu_id']}");
			exit();
		}
	}

	function delete($pid = FALSE) {
		$this->load->model('cms/Menulinkmodel');

		$page_details = $this->Menulinkmodel->fetchById($pid);
		if (!$page_details) {
			$this->http->show404();
			return;
		}

		$this->Menulinkmodel->deleteRecord($page_details);
		$this->session->set_flashdata('SUCCESS', 'menu_item_deleted');
		redirect("cms/menu_item/index/{$page_details['menu_id']}");
		exit();
	}

	//update the product order
	function updateorder() {
		$sortOrder = $this->input->post('debugStr', TRUE);

		if ($sortOrder) {
			$sortOrder = trim($sortOrder);
			$sortOrder = trim($sortOrder, ',');
			//file_put_contents('facelube.txt',serialize($sortOrder));
			$chunks = explode(',', $sortOrder);
			$counter = 1;
			foreach ($chunks as $id) {
				$data = array();
				$data['menu_sort_order'] = $counter;
				$this->db->where('menu_item_id', intval($id));
				$this->db->update('menu_link', $data);
				$counter++;
			}
		}
	}

}

?>