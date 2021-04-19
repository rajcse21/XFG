<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contenttype extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

  function updateSortOrder() {
        $sort_data = $this->input->post('content_type', true);
        foreach ($sort_data as $key => $val) {
            $update = array();
            $update['content_type_sort_order'] = $key + 1;
            $this->db->where('content_type_id', $val);
            $this->db->update('content_type', $update);
        }
        //echo "Done";
        print_r($_POST);
    }

   
}

?>