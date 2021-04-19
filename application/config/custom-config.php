<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

$config['EMAIL_CONFIG'] = array(
	'mailtype' => 'html'
);
define('ROOT_APPPATH', str_replace('\\', '/', realpath(APPPATH . '../')) . '/');

//get path of various files upload in website
$config['RESIZED_CACHE_PATH'] = str_replace('\\', '/', realpath(BASEPATH . '../')) . '/tmp/resize/';
$config['RESIZED_CACHE_URL'] = $this->config['base_url'] . '/tmp/resize/';

$config['UPLOAD_PATH'] = ROOT_APPPATH . 'upload/';
$config['UPLOAD_URL'] = $this->config['base_url'] . 'upload/';

$config['FORM_FILES_PATH'] = $config['UPLOAD_PATH'] . 'forms/';
$config['FORM_FILES_URL'] = $config['UPLOAD_URL'] . 'forms/';

$config['SITE_NAME'] = 'XFG';

$config['DWS_SALT_LENGTH'] = 5;
