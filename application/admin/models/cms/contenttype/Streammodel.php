<?php

class Streammodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	//Function count all streams
	function countAll($ctid) {
		$this->db->from('content_stream');
		$this->db->where('content_type_id', intval($ctid));
		return $this->db->count_all_results();
	}

	//List All templates
	function listAll($ctid, $offset = FALSE, $limit = FALSE) {
		if ($offset)
			$this->db->offset($offset);
		if ($limit)
			$this->db->limit($limit);
		$this->db->select('content_stream.*, content_type.content_type_name');
		$this->db->from('content_stream');
		$this->db->join('content_type', 'content_type.content_type_id = content_stream.content_type_id');
		$this->db->where('content_stream.content_type_id', intval($ctid));
		$rs = $this->db->get();
		return $rs->result_array();
	}

	//Function insert record
	function insertRecord($content_type) {
		$data = array();

		$data['content_type_id'] = $content_type['content_type_id'];
		$data['stream_name'] = $this->input->post('stream_name', TRUE);
		if ($this->input->post('stream_alias', TRUE) == '') {
			$data['stream_alias'] = $this->_slug($this->input->post('stream_name', TRUE));
		} else {
			$data['stream_alias'] = url_title(strtolower($this->input->post('stream_alias', TRUE)));
		}
		$data['item_per_stream'] = $this->input->post('item_per_stream', TRUE);
		$data['show_pagination'] = $this->input->post('show_pagination', TRUE);
		$data['filter_by'] = $this->input->post('filter_by', FALSE);
		$data['item_template'] = $this->input->post('item_template', FALSE);
		$data['stream_updated_on'] =time();

		$this->db->insert('content_stream', $data);
	}

	//Get stream details
	function detail($sid) {
		$this->db->select('content_stream.*, content_type.content_type_name');
		$this->db->from('content_stream');
		$this->db->join('content_type', 'content_type.content_type_id = content_stream.content_type_id');
		$this->db->where('content_stream_id', intval($sid));
		$rs = $this->db->get();
		if ($rs->num_rows() == 1)
			return $rs->row_array();

		return FALSE;
	}

	//Function update record
	function updateRecord($stream) {
		$data = array();
		$data['stream_name'] = $this->input->post('stream_name', TRUE);
		if ($this->input->post('stream_alias', TRUE) == '') {
			$data['stream_alias'] = $this->_slug($this->input->post('stream_name', TRUE));
		} else {
			$data['stream_alias'] = url_title(strtolower($this->input->post('stream_alias', TRUE)));
		}
		$data['item_per_stream'] = $this->input->post('item_per_stream', TRUE);
		$data['show_pagination'] = $this->input->post('show_pagination', TRUE);
		$data['filter_by'] = $this->input->post('filter_by', FALSE);
		$data['item_template'] = $this->input->post('item_template', FALSE);
		$data['stream_updated_on'] =time();

		$this->db->where('content_stream_id', $stream['content_stream_id']);
		$this->db->update('content_stream', $data);
	}

	//Function delete records
	function deleteRecord($stream) {
		$this->db->where('content_stream_id', $stream['content_stream_id']);
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
		$this->db->where('stream_alias', $slug);
		$rs = $this->db->get('content_stream');
		if ($rs->num_rows() > 0) {
			$suffix = 2;
			do {
				$slug_check = false;
				$alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
				$this->db->limit(1);
				$this->db->where('stream_alias', $alt_slug);
				$rs = $this->db->get('content_stream');
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
