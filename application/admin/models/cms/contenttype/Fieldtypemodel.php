<?php

class Fieldtypemodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	
	//List All field type field group
	function listAll($offset = FALSE, $limit = FALSE) {
		if ($offset)
			$this->db->offset($offset);
		if ($limit)
			$this->db->limit($limit);

		$this->db->order_by('field_type_id', 'ASC');
		$rs = $this->db->get('field_type');
		return $rs->result_array();
	}

}

?>
