<?php

class Globalmodel extends CI_Model {

	function fetchGlobalBlockById($global_block_id){
		$this->db->where('global_block_id',$global_block_id);
		$rs = $this->db->get('global_block');
		if($rs && $rs->num_rows() == 1){
			return $rs->row_array();
		}
		return FALSE;
	}
	
	function fetchGlobalSectionById($global_section_id){
		$this->db->where('global_section_id',$global_section_id);
		$rs = $this->db->get('global_section');
		if($rs && $rs->num_rows() == 1){
			return $rs->row_array();
		}
		return FALSE;
	}
		function fetchGlobalSectionByAlias($global_section_alias) {

		$this->db->where('page_section_alias', $global_section_alias);
		$rs = $this->db->get('global_section');
		if ($rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return false;
	}
	
}

?>