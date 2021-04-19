<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menuitem extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->is_admin_protected = TRUE;
	}

	function updateSortOrder(){
		$sort_data = $this->input->post('menu', true);
		foreach($sort_data as $key=>$val) {
			$update = array();
			$update['menu_sort_order'] = $key+1;
			$this->db->where('menu_item_id', $val);
			$this->db->update('menu_item', $update);
		}
		//echo "Done";
        print_r($_POST);
	}
}
?>