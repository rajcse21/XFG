<?php

class Formmodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function countAll($filter = false) {
		if (isset($filter['from_date']) && $filter['from_date'] != '' && isset($filter['to_date']) && $filter['to_date'] != '') {
			$from_date = strtotime($filter['from_date']);
			$to_date = strtotime($filter['to_date']);
			$this->db->where("submitted_on BETWEEN '$from_date' AND '$to_date'");
		}
		return $this->db->count_all_results('form_entry');
	}

	function listAll($offset = FALSE, $perpage = FALSE, $filter = false) {
		if ($offset)
			$this->db->offset($offset);
		if ($perpage)
			$this->db->limit($perpage);
		if (isset($filter['from_date']) && $filter['from_date'] != '' && isset($filter['to_date'])) {
			$from_date = strtotime($filter['from_date']);
			$to_date = strtotime($filter['to_date'] . "23:59:00");
			$this->db->where("submitted_on BETWEEN '$from_date' AND '$to_date'");
		}
		$this->db->order_by('form_entry_id', 'DESC');
		$rs = $this->db->get('form_entry');

		if ($rs && $rs->num_rows() > 0) {
			return $rs->result_array();
		}
		return FALSE;
	}

	function fetchById($id) {
		$this->db->where('form_entry_id', $id);
		$rs = $this->db->get('form_entry');

		if ($rs && $rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return FALSE;
	}

}

?>
