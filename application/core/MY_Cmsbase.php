<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Cmsbase extends CI_Controller {

    function setPage($page) {
        $this->core->setPage($page);
    }

    function getPage() {
        return $this->core->getPage();
    }

}

/* End of file cms.php */
/* Location: ./application/libraries/cms.php */