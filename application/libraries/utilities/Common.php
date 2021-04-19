<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common {

    function __construct() {
        log_message('debug', "Commonlib Class Initialized");
        $this->CI = & get_instance();
    }

    function listBanklogos($order_by = 'ASC', $limit = false) {
        if ($limit)
            $this->CI->db->limit($limit);

        $this->CI->db->order_by('bank_logo_sort_order', $order_by);
        $rs = $this->CI->db->get('bank_logo');
        if ($rs && $rs->num_rows() > 0) {
            return $rs->result_array();
        }
        return false;
    }

}
