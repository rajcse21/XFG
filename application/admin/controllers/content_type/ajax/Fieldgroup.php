<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Fieldgroup extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->is_admin_protected = TRUE;
	}

	function updateSortOrder() {
		$sort_data = $this->input->post('table_fields', true);
		foreach ($sort_data as $key => $val) {
			if ($key == 0) {
				continue;
			}
			$update = array();
			$update['content_fieldgroup_sort_order'] = $key;
			$this->db->where('content_fieldgroup_id', $val);
			$this->db->update('content_fieldgroup', $update);
		}
		//echo "Done";
	}
}

?>