<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//use Guzzle\Http\Client;

class Form extends CI_Controller {

    public function Contact_frm() {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->library('email');

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

        $output = array();
        if ($this->form_validation->run() == FALSE) {
            $err = array();
            $err['name'] = form_error('name');
            $err['email'] = form_error('email');
            $err['phone'] = form_error('phone');
            $err['subject'] = form_error('subject');
            $err['message'] = form_error('message');
            $output['errors'] = $err;
            $output['status'] = 'ERROR';
            echo json_encode($output);
            exit();
        } else {
            $data = array();
            $data['name'] = $this->input->post('name', true);
            $data['email'] = $this->input->post('email', true);
            $data['phone'] = $this->input->post('phone', true);
            $data['referrer_url'] = $this->input->post('referrer_url', true);
            $data['form_url'] = $this->input->post('form_url', true);
            $data['form_type'] = $this->input->post('form_type', true);
            $data['visitor_ip'] = $this->http->getIP();

            $form_data = array();
            $form_data['name'] = $data['name'];
            $form_data['email'] = $data['email'];
            $form_data['phone'] = $data['phone'];
            $form_data['subject'] = $this->input->post('subject', true);
            $form_data['message'] = $this->input->post('message', true);
            $form_data['referrer_url'] = $data['referrer_url'];
            $form_data['form_url'] = $data['form_url'];
            $form_data['form_type'] = $data['form_type'];
            $form_data['visitor_ip'] = $data['visitor_ip'];
			$form_data['page_name'] =$this->input->post('page_name',true);
			$form_data['page_url'] = $this->input->post('page_url',true);

            $data['form_data'] = base64_encode(serialize($form_data));
            $data['submitted_on'] = time();
            $this->db->insert('form_entry', $data);

            $emailData = array();
            $emailData['DATE_CURRENT'] = date("jS F, Y");
            $emailData['NAME'] = $form_data['name'];
            $emailData['EMAIL'] = $form_data['email'];
            $emailData['PHONE'] = $form_data['phone'];
            $emailData['SUBJECT'] = $this->input->post('subject', true);
            $emailData['MESSAGE'] = $this->input->post('message', true);
            $emailData['SITE_URL'] = base_url();

            $emailBody = $this->view->load('emails/contact_email_form', $emailData, TRUE);

            $this->email->initialize($this->config->item('EMAIL_CONFIG'));
            $this->email->from($this->core->CONFIG_EMAIL_NOREPLY, $this->core->CONFIG_EMAIL_FROM);
            $this->email->to($this->core->CONFIG_EMAIL_ADMIN);
            $this->email->subject('Contact Form');
            $this->email->message($emailBody);
            //$status = true;
             $status = $this->email->send();
            if ($status) {
                $output['status'] = 'SUCCESS';
                $output['message'] = 'thank-you';
                echo json_encode($output);
                exit();
            }

            $output['status'] = 'FAILED';
            $output['message'] = 'error';
            echo json_encode($output);
            exit();
        }
    }

}
