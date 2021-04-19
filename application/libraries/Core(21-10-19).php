<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use Assetic\Asset\AssetCollection;

class Core {

    private $data = array();
    private $CI;
    public $apiContext = false;

    function __construct() {
        $this->CI = & get_instance();
        $this->_initialize_core();
    }

    function _initialize_core() {
        define('THEME', 'default');
        define('THEME_PATH', 'themes/' . THEME);
        define('ASSETS_PATH', 'assets/themes/' . THEME);
        define('ASSETS_FOLDER', 'assets/themes/' . THEME);


        // Load DB and set DB preferences
        $this->CI->load->database();

        //Session
        $this->CI->load->library('session');

        $this->CI->CSS = new AssetCollection();
        $this->CI->CSS->ensureFilter(new Assetic\Filter\CssRewriteFilter());
        $this->CI->CSS->setTargetPath('min-styles.css');

        $this->CI->JS = new AssetCollection();
        $this->CI->JS->setTargetPath('min-scripts.js');

        //Native Helpers
        $this->CI->load->helper('url');
        $this->CI->load->helper('form');

        //DWS Libraries
        $this->CI->load->library('core/http');
        $this->CI->load->library('core/html');
        $this->CI->load->library('core/meta');
        $this->CI->load->library('core/view');
        $this->CI->load->library('cmscore');
        //$this->CI->load->helper('image');
        //$this->CI->load->library('app/memberauth');
        //$this->CI->load->library('app/school');
        //$this->CI->load->library('cart');
        $this->CI->load->library('filemanager');
        $this->CI->load->library('utilities/Common');

        $this->CI->config->load('custom-config');

        //Informational Messages		
        $info = '';
        $info_key = $this->CI->session->flashdata('INFO');
        if ($info_key) {
            $this->CI->lang->load('info', 'english');
            $info = $this->CI->lang->line($info_key);
            $this->CI->load->vars(array('INFO' => $info));
        }

        //Error Messages
        $error = '';
        $error_key = $this->CI->session->flashdata('ERROR');
        if ($error_key) {
            $this->CI->lang->load('error', 'english');
            $error = $this->CI->lang->line($error_key);
            $this->CI->load->vars(array('ERROR' => $error));
        }

        //Success Messages
        $success = '';
        $success_key = $this->CI->session->flashdata('SUCCESS');
        if ($success_key) {
            $this->CI->lang->load('success', 'english');
            $success = $this->CI->lang->line($success_key);
            $this->CI->load->vars(array('SUCCESS' => $success));
        }

        $this->CI->load->vars(array('CI' => $this->CI));
    }

    function saveConfig($key, $val) {
        $key = str_replace("CONFIG_", "", $key);

        $data['config_value'] = $val;
        $this->CI->db->where('config_key', $key);
        $this->CI->db->update('config', $data);
    }

    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    public function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $this->CI->db->where('config_key', str_replace("CONFIG_", "", $name));
        $rs = $this->CI->db->get('config');
        if ($rs && $rs->num_rows() == 1) {
            $row = $rs->row_array();
            $this->data[$name] = $row['config_value'];
            return $this->data[$name];
        }

        return null;
    }

}
