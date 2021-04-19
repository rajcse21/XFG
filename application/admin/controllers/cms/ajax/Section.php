<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Section extends CI_Controller {

	function __construct() {
		parent::__construct();
		//Check For User Login
		$user = $this->userauth->checkAuth();
		if (!$user) {
			redirect("user");
		}
	}

	function updateSortOrder() {
		$sort_data = $this->input->post('section', true);
		foreach ($sort_data as $key => $val) {
			$update = array();
			$update['page_section_sort_order'] = $key + 1;
			$this->db->where('page_section_id', $val);
			$this->db->update('page_section', $update);
		}
		echo "Done";
		//print_r($_POST);
	}

}

?>