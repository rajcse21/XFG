<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Cms extends CI_Controller {

	function index($alias = false) {
		$page_arr = $this->cmscore->loadPage($alias);
		if (!$page_arr) {
			$this->http->show404();
			return;
		}
		$this->cmscore->renderPage($page_arr);
	}

}
