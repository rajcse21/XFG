<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

$config['EMAIL_CONFIG'] = array(
	'mailtype' => 'html'
);
define('TYPE_PAGE', 1);
define('TYPE_NODE_TEXT', 2);
define('TYPE_NODE_WYSIWYG', 3);

$config['DEFAULT_LANG'] = 'en';
$config['SELECTED_LANG'] = 'en';

define('ROOT_APPPATH', str_replace('\\', '/', realpath(APPPATH . '../../')) . '/');

$config['UPLOADS_PATH'] = ROOT_APPPATH . 'upload/';
$config['UPLOADS_URL'] = $this->config['site_url'] . 'upload/';


$config['TEMPLATE_PATH'] = ROOT_APPPATH . 'application/views/themes/' . THEME . "/templates/";

$config['BANK_LOGO_PATH'] = $config['UPLOADS_PATH'] . 'bank_logos/';
$config['BANK_LOGO_URL'] = $config['UPLOADS_URL'] . 'bank_logos/';

//Paths and URLs
$config['UPLOADS_PATH'] = str_replace('\\', '/', realpath(BASEPATH . '../')) . '/uploads/';
$config['UPLOADS_URL'] = $this->config['base_url'] . 'uploads/';

$config['FILEMANAGER_PATH'] = $this->config['site_url'] . 'filemanager/dialog.php?type=1&akey=sdfsd4dc';
$config['FILEMANAGER_FILE_PATH'] = $this->config['site_url'] . 'filemanager/dialog.php?type=2&akey=sdfsd4dc';
$config['FILEMANAGER_VIDEO_PATH'] = $this->config['site_url'] . 'filemanager/dialog.php?type=3&akey=sdfsd4dc';
$config['FILEMANAGER_STANDALONE_PATH'] = $this->config['site_url'] . 'filemanager/dialog.php?type=0&akey=sdfsd4dc';

$config['SITE_NAME'] = 'XFG';

