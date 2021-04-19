<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_logo extends CI_Controller {

    function __construct() {
        parent::__construct();

        //Check For User Login
        $user = $this->userauth->checkAuth();
        if (!$user) {
            redirect("user");
        }
        $this->load->vars(array('active_menu' => 'content'));
    }

    function index($offset = false) {
        $this->load->model('Banklogomodel');
        $this->load->library('pagination');

        $this->meta->setTitle('Manage Bank Logos - {SITE_NAME}');


        //Setup pagination
        $limit = 100;
        $config['base_url'] = base_url() . "bank_logo/index";
        $config['uri_segment'] = 3;
        $config['total_rows'] = $this->Banklogomodel->countAll();
        $config['per_page'] = $limit;
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['prev_link'] = FALSE;
        $config['next_link'] = FALSE;
        $config['last_link'] = '&raquo;';
        $config['first_link'] = '&laquo;';
        $config['attributes'] = array('class' => 'page-link');
        $config['reuse_query_string'] = FALSE;
        $config['page_query_string'] = FALSE;
        $this->pagination->initialize($config);


        $bank_logos = $this->Banklogomodel->listAll($offset, $limit);
        //Render View
        $inner = ['bank_logos' => $bank_logos, 'pagination' => $this->pagination->create_links()];

        $shell = array();
        $shell['contents'] = $this->view->load("bank-logo/listing", $inner, TRUE);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }

    function updateSortOrder() {
        $sort_data = $this->input->post('bank_logo', true);
        foreach ($sort_data as $key => $val) {
            $update = array();
            $update['bank_logo_sort_order'] = $key + 1;
            $this->db->where('bank_logo_id', $val);
            $this->db->update('bank_logo', $update);
        }
        echo "Done";
    }

    public function delete($bid) {
        $this->load->model('Banklogomodel');

        $bank_logo = $this->Banklogomodel->fetchByID($bid);

        if (!$bank_logo) {
            $this->http->show404();
            return;
        }
        $this->db->where('bank_logo_id', $bank_logo['bank_logo_id']);
        $this->db->delete('bank_logo');
        redirect('bank_logo');
    }

    public function file_upload() {
        $this->load->model('Banklogomodel');
        log_message('error', 'FILES' . json_encode($_FILES));

        $config = array();
        $config['upload_path'] = config_item('BANK_LOGO_PATH');
        $config['overwrite'] = TRUE;
        $config['allowed_types'] = 'gif|jpg|png';
        $this->load->library('upload', $config);
        if (count($_FILES) > 0) {
            $files = $_FILES;
            $total = count($_FILES['file']['name']);
            for ($i = 0; $i < $total; $i++) {
                if ($_FILES['file']['error'][$i] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file']['tmp_name'][$i])) {
                    $_FILES['upload_data']['name'] = $files['file']['name'][$i];
                    $_FILES['upload_data']['type'] = $files['file']['type'][$i];
                    $_FILES['upload_data']['tmp_name'] = $files['file']['tmp_name'][$i];
                    $_FILES['upload_data']['error'] = $files['file']['error'][$i];
                    $_FILES['upload_data']['size'] = $files['file']['size'][$i];

                    if (!$this->upload->do_upload('upload_data')) {
                        $this->ajax->error(['message' => $this->upload->display_errors('', '')]);
                    } else {
                        $upload_data = $this->upload->data();
                        $data = [];
                        $data['bank_logo'] = config_item('BANK_LOGO_URL') . $upload_data['file_name'];
                        $data['bank_logo_sort_order'] = $this->Banklogomodel->getOrder();
                        $status = $this->db->insert('bank_logo', $data);
                    }
                }
            }

            if ($status) {
                $this->session->set_flashdata('SUCCESS', "Logos uploaded successfully.");
                $output = [];
                $output['message'] = 'Logos has been uploaded successfully.';
                $this->ajax->success($output);
            }
        }
    }

}
