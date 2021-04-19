<?php

class Settingsmodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function getAllConfig($group_id = false) {
		if ($group_id) {
			$this->db->where('config_group_id', $group_id);
		} else {
			$this->db->where('editable', 1);
		}
		$this->db->order_by('config_sortorder', 'ASC');
		$this->db->order_by('config_key', 'ASC');
		$rs = $this->db->get('config');
		return $rs->result_array();
	}

	function getConfigByGroup($group_id) {
		$this->db->where('config_group_id', $group_id);
		$this->db->where('editable', 1);
		$rs = $this->db->get('config');
		return $rs->result_array();
	}

	function getByKey($key) {
		$this->db->where('config_key', $key);
		$this->db->where('editable', 1);
		$rs = $this->db->get('config');
		if ($rs->num_rows() == 1) {
			return $rs->row_array();
		}
	}

	function fetchConfigGroup($group_id) {
		$this->db->where('config_group_id', $group_id);
		$rs = $this->db->get('config_group');
		return $rs->result_array();
	}

	function getConfigGroups() {
		$rs = $this->db->get('config_group');
		return $rs->result_array();
	}

	function update($settings) {
		
		$config = array();
		$config['upload_path'] = $this->config->item('CONTACT_US_FILE_PATH');
		$this->load->library('upload', $config);

		foreach ($settings as $row) {
			//print_R($_POST); exit();
			//For WYSIWYG
			$data = array();
			$data['config_value'] = $this->input->post($row['config_key'], FALSE);

			$this->db->where('config_key', $row['config_key']);
			$this->db->update('config', $data);
		}
	}

	function DeleteImage($setting) {

		$path = $this->config->item('CONTACT_US_FILE_PATH');
		$imagepath = $path . $setting['config_value'];

		if (file_exists($imagepath)) {
			@unlink($imagepath);
		}
		$data['config_value'] = '';
		//	  print_R($data); exit();
		$this->db->where('config_key', $setting['config_key']);
		$this->db->update('config', $data);
	}

}

?>
