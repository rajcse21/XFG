<?php

class Menulinkmodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	//List All Records
	function getAll($menu_id) {
		$this->db->where('menu_id', $menu_id);
		$this->db->order_by('menu_sort_order', 'ASC');
		$rs = $this->db->get('menu_item');
		return $rs->result_array();
	}

	//function to list all pages in indented
	function listMenuItems($parent, $mid, &$output = array()) {
		$this->db->where('parent_id', $parent);
		$this->db->where('menu_id', $mid);
		$this->db->order_by('menu_sort_order', 'ASC');
		$query = $this->db->get('menu_item');
		foreach ($query->result_array() as $row) {
			$output[] = $row;
			$this->indentedActiveList($row['menu_item_id'], $mid, $output);
		}
		return $output;
	}

	function indentedActiveList($parent, $mid, &$output = array()) {
		$this->db->where('parent_id', $parent);
		$this->db->where('menu_id', $mid);
		$this->db->order_by('menu_sort_order', 'ASC');
		$query = $this->db->get('menu_item');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$output[$row['menu_item_id']] = $row;
				$this->indentedActiveList($row['menu_item_id'], $mid, $output);
			}
		}
		return $output;
	}

	//Get sort order of menu items
	function getOrder($mid) {
		$this->db->select_max('menu_sort_order');
		$this->db->where('menu_id', $mid);
		$query = $this->db->get('menu_item');
		$sort_order = $query->row_array();
		return $sort_order['menu_sort_order'] + 1;
	}

	//Function intende list
	function indentedList($menu_id, $exclude = false, $parent_id = 0, &$output = array()) {
		$this->db->where('menu_id', $menu_id);
		$this->db->where('parent_id', $parent_id);
		if ($exclude) {
			$this->db->where('menu_item_id !=', $exclude);
		}
		$this->db->order_by('menu_sort_order', 'ASC');
		$query = $this->db->get('menu_item');

		foreach ($query->result_array() as $row) {
			$output[] = $row;
			$this->indentedList($menu_id, $exclude, $row['menu_item_id'], $output);
		}
		return $output;
	}

	function fetchById($pid) {
		$this->db->from('menu_item');
		$this->db->where('menu_item_id', intval($pid));
		$rs = $this->db->get();
		if ($rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return FALSE;
	}

	//Function insert record
	function insertRecord($menu_detail_id) {
		$data = array();
		$data['menu_item_name'] = $this->input->post('menu_item_name', TRUE);
		$data['menu_item_identifier'] = url_title(strtolower($this->input->post('menu_item_identifier', TRUE)));
		//$data['menu_item_icon'] = $this->input->post('menu_item_icon', false);
		$data['menu_item_type'] = $this->input->post('menu_item_type', TRUE);
		$data['menu_id'] = $menu_detail_id;
		$data['parent_id'] = $this->input->post('parent_id', TRUE);
		$data['new_window'] = $this->input->post('new_window', TRUE);
		$data['menu_item_class'] = $this->input->post('menu_item_class', TRUE);

		switch ($this->input->post('menu_item_type', TRUE)) {
			case "page":
				$data['content_id'] = $this->input->post('content_id', TRUE);
				$data['is_placeholder'] = 0;
				break;
			case "url":
				$data['url'] = $this->input->post('url', TRUE);
				$data['is_placeholder'] = 0;
				break;
			case "placeholder":
				$data['is_placeholder'] = 1;
				break;
		}

		$order = $this->getOrder($menu_detail_id);
		$data['menu_sort_order'] = $order;
		if ($this->input->post('parent_id', true) == 0) {
			$data['menu_item_level'] = 0;
			$data['menu_item_path'] = 0;
		} else {
			$parent_menu = $this->fetchById($this->input->post('parent_id', true));
			$data['menu_item_level'] = $parent_menu['menu_item_level'] + 1;
			$data['menu_item_path'] = $parent_menu['menu_item_path'] . '.' . $this->input->post('parent_id', true);
		}
		$this->db->insert('menu_item', $data);
		return;
	}

	function updateRecord($menu_detail) {
		$data = array();
		$data['menu_item_name'] = $this->input->post('menu_item_name', TRUE);
		$data['menu_item_identifier'] = url_title(strtolower($this->input->post('menu_item_identifier', TRUE)));
		//$data['menu_item_icon'] = $this->input->post('menu_item_icon', false);
		$data['menu_item_name'] = $this->input->post('menu_item_name', TRUE);
		$data['menu_item_type'] = $this->input->post('menu_item_type', TRUE);
		$data['menu_id'] = $menu_detail['menu_id'];
		$data['parent_id'] = $this->input->post('parent_id', TRUE);
		$data['new_window'] = $this->input->post('new_window', TRUE);
		$data['menu_item_class'] = $this->input->post('menu_item_class', TRUE);
		switch ($this->input->post('menu_item_type', TRUE)) {
			case "page":
				$data['content_id'] = $this->input->post('content_id', TRUE);
				$data['is_placeholder'] = 0;
				$data['url'] = '';
				break;
			case "url":
				$data['url'] = $this->input->post('url', TRUE);
				$data['content_id'] = 0;
				$data['is_placeholder'] = 0;
				break;
			case "placeholder":
				$data['is_placeholder'] = 1;
				$data['content_id'] = 0;
				$data['url'] = '';
				break;
		}

		if ($this->input->post('parent_id', true) == 0) {
			$data['menu_item_level'] = 0;
			$data['menu_item_path'] = 0;
		} else {
			$parent_menu = $this->fetchById($this->input->post('parent_id', true));
			$data['menu_item_level'] = $parent_menu['menu_item_level'] + 1;
			$data['menu_item_path'] = $parent_menu['menu_item_path'] . '.' . $this->input->post('parent_id', true);
		}

		$this->db->where('menu_item_id', $menu_detail['menu_item_id']);
		$this->db->update('menu_item', $data);
		return;
	}

	function menuItemTree($mid) {
		$this->db->order_by('menu_sort_order', 'ASC');
		$this->db->where('menu_id', $mid);
		$query = $this->db->get('menu_item');

		return $this->_menuItemTree($query->result_array());
	}

	function _menuItemTree(array $elements, $parentId = 0) {
		/*if ($parentId == 0) {
			$output = '<ul class="ui-sortable" id="sortable">';
		} else {
			$output = '';
		}

		foreach ($elements as $element) {
			if ($element['parent_id'] == $parentId) {

				$links = array(
					anchor("cms/menu_item/edit/{$element['menu_item_id']}", "Edit"),
					anchor("cms/menu_item/delete/{$element['menu_item_id']}", "Delete"),
				);

				$row = '<div class="rows">
					<div class="col-md-6 text-left">' . anchor("cms/menu_item/edit/{$element['menu_item_id']}", $element['menu_item_name']) . '</div>
					<div class="col-md-6 text-right">' . implode(' | ', $links) . '</div>
				</div>';

				$output .= '<li id="menu_' . $element['menu_item_id'] . '">' . $row;
				$children = $this->_menuItemTree($elements, $element['menu_item_id']);
				if ($children) {
					$output .= '<ul><li>' . $children . "</li></ul>\r\n";
				}
				$output .= "</li>\r\n";
			}
		}

		if ($parentId == 0) {
			$output .= '</ul>';
		}*/
		$inner = array();
		$inner['elements'] = $elements;
		$inner['parentId'] = $parentId;
		return $this->view->load('cms/menus/menu_items/index-tree', $inner, TRUE);

		return $output;
	}

	//Function delete records
	function deleteRecord($menu_item) {
		$data = array();
		$data['parent_id'] = $menu_item['parent_id'];
		$this->db->where('parent_id', $menu_item['menu_item_id']);
		$this->db->update('menu_item', $data);

		$this->db->where('menu_item_id', $menu_item['menu_item_id']);
		$this->db->delete('menu_item');
	}

}

?>