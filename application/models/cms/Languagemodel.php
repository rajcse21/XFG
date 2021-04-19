<?php

class Languagemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Get language
    function getLanguage($lang_code) {
        $this->db->where('language_code', $lang_code);
        $rs = $this->db->get('language');
        if ($rs && $rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return FALSE;
    }
    
    //Fetch all languages
    function getAllLanguages($select = false) {
		if($select) {
			$this->db->select($select);
		}
        $this->db->from('language');
        $rs = $this->db->get();
        if ($rs) {
            return $rs->result_array();
        }
        return FALSE;
    }
}