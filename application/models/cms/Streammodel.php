<?php

class Streammodel extends CI_Model {

	//function get Stream details
	function fetchByAlias($type, $alias) {
		$page = array();
		$this->db->from('content_stream');
		$this->db->join('content_type', 'content_type.content_type_id = content_stream.content_type_id');
		$this->db->where('content_type_alias', $type);
		$this->db->where('stream_alias', $alias);
		$rs = $this->db->get();

		if ($rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return false;
	}

	function listItems($stream) {
		$this->db->from('page_i18n');
		$this->db->join('page', 'page.page_id = page_i18n.page_id');
		$this->db->join('content_type', 'content_type.content_type_id = page.content_type_id');
		$this->db->where('page.content_type_id', $stream['content_type_id']);
		$this->db->order_by('page_sort_order', 'ASC');
		$this->db->where('page_status', 'Publish');
		//$this->db->where('active', 1);
		$this->db->limit($stream['item_per_stream']);
		$rs = $this->db->get();
		
		$pages = array();
		if ($rs->num_rows() > 0) {
			foreach ($rs->result_array() as $page) {
				$fields = $this->Pagemodel->getPageFieldData($page['page_i18n_id'], $page['content_type_id']);
				if (!empty($fields)) {
					foreach ($fields as $key=>$value) {
						$page[$key] = $value;
					}
				}
				$pages[] = $page;				
			}
			return $pages;
		}
		return false;
	}

}

?>