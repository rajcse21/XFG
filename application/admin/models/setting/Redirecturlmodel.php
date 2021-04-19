<?php

class Redirecturlmodel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function insertrecord() {
        $str = $this->input->post('redirect_url', true);
        if ($str) {
            //delete previous record
            $this->db->truncate('redirect_url');

            $str_rs = preg_split('/\r\n|\r|\n/', trim($str));
            foreach ($str_rs as $item) {
                $str_array = array();
                $str_array = explode('->', $item);
                //insert new record
                $data = array();
                if (isset($str_array[0]))
                    $data['old_url'] = trim($str_array[0]);
                if (isset($str_array[1]))
                    $data['new_url'] = trim($str_array[1]);
                $this->db->insert('redirect_url', $data);
            }
        }
    }

    function listRedirectURLS() {
        $this->db->from('redirect_url');
        $rs = $this->db->get();
        return $rs->result_array();
    }

}

?>
