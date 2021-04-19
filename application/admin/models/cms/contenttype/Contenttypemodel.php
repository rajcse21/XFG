<?php

class Contenttypemodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	//function to get sort order
	function getSortOrder() {
		$this->db->select_max('content_type_sort_order');
		$query = $this->db->get('content_type');
		$sort_order = $query->row_array();
		return $sort_order['content_type_sort_order'] + 1;
	}

	//get page type detail
	function fetchById($content_type_id) {
		$this->db->from('content_type');
		$this->db->where('content_type_id', intval($content_type_id));
		$this->db->limit(1);
		$rs = $this->db->get();
		if ($rs && $rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return FALSE;
	}

	//Count All Records
	function countAll() {
		$this->db->from('content_type');
		return $this->db->count_all_results();
	}

	function listAll($offset = FALSE, $limit = FALSE) {
		if ($offset) {
			$this->db->offset($offset);
		}
		if ($limit) {
			$this->db->limit($limit);
		}

		$this->db->order_by('content_type_sort_order', 'ASC');
		$query = $this->db->get('content_type');
		return $query->result_array();
	}

	function insertRecord() {
		$data = array();
		$data['content_type_name'] = $this->input->post('content_type_name', True);
		$data['singular_name'] = ucfirst($this->input->post('singular_name', True));
		$data['node_type'] = $this->input->post('node_type', True);
		$data['content_tab'] = $this->input->post('content_tab', True);
		if ($this->input->post('content_type_alias', TRUE) == '') {
			$data['content_type_alias'] = $this->_slug($this->input->post('content_type_name', TRUE));
		} else {
			$data['content_type_alias'] = url_title(strtolower($this->input->post('content_type_alias', TRUE)));
		}
		$data['content_type_sort_order'] = $this->getSortOrder();
		$this->db->insert('content_type', $data);
	}

	//update page type
	function updateRecord($content_type) {
		$data = array();
		$data['content_type_name'] = $this->input->post('content_type_name', True);
		$data['singular_name'] = ucfirst($this->input->post('singular_name', True));
		$data['node_type'] = $this->input->post('node_type', True);
		$data['content_tab'] = $this->input->post('content_tab', True);
		if ($this->input->post('content_type_alias', TRUE) == '') {
			$data['content_type_alias'] = $this->_slug($this->input->post('content_type_name', TRUE));
		} else {
			$data['content_type_alias'] = url_title(strtolower($this->input->post('content_type_alias', TRUE)));
		}
		$this->db->where('content_type_id', intval($content_type['content_type_id']));
		$this->db->update('content_type', $data);
	}

	//delete page type
	function deleteRecord($content_type) {

		// delete content type
		$this->db->where('content_type_id', intval($content_type['content_type_id']));
		$this->db->delete('content_type');

		// delete content type fields
		$this->db->where('content_type_id', intval($content_type['content_type_id']));
		$this->db->delete('content_field');

		// delete content type field Groups	
		$this->db->where('content_type_id', intval($content_type['content_type_id']));
		$this->db->delete('content_fieldgroup');

		// delete content type streams
		$this->db->where('content_type_id', intval($content_type['content_type_id']));
		$this->db->delete('content_stream');
	}

	//function for content type alias
	function _slug($name) {
		$content_name = ($name) ? $name : '';

		$replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`', '#');

		$slug = $content_name;
		$slug = trim($slug);
		$slug = str_replace($replace_array, "", $slug);
		$slug = url_title($slug, 'dash', true);
		$this->db->limit(1);
		$this->db->where('content_type_alias', $slug);
		$rs = $this->db->get('content_type');
		if ($rs->num_rows() > 0) {
			$suffix = 2;
			do {
				$slug_check = false;
				$alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
				$this->db->limit(1);
				$this->db->where('content_type_alias', $alt_slug);
				$rs = $this->db->get('content_type');
				if ($rs->num_rows() > 0)
					$slug_check = true;
				$suffix++;
			}while ($slug_check);
			$slug = $alt_slug;
		}

		return $slug;
	}

}

?>