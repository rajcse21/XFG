<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function login() {
		$this->load->model('Usermodel');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('text');
		$this->load->library('encryption');

		//echo password_hash('admin', PASSWORD_BCRYPT);

		$this->meta->setTitle('User Login - {SITE_NAME}');

		$this->form_validation->set_rules('email', 'Email', 'is_string|trim|required');
		$this->form_validation->set_rules('passwd', 'Password', 'is_string|trim|required');
		$this->form_validation->set_rules('login', 'Login', array(
			'is_string',
			'trim',
			'required',
			array(
				'login_check',
				function($str) {
					$this->db->where('username', $this->input->post('email', TRUE));
					$this->db->where('user_is_active', 1);
					$this->db->limit(1);
					$query = $this->db->get('admin_user');
					if ($query && $query->num_rows() == 1) {
						$row = $query->row_array();
						if (password_verify($this->input->post('passwd', TRUE), $row['passwd'])) {
							return true;
						}
					}

					$this->form_validation->set_message('login_check', '<strong>Login failed!</strong> Please check your login details.');
					return false;
				}
			))
		);
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			$shell = array();
			$shell['contents'] = $this->view->load("user/login-form", array(), true);
			$this->load->view("themes/" . THEME . "/templates/user", $shell);
		} else {
			$this->db->where('username', $this->input->post('email', true));
			$this->db->where('user_is_active', 1);
			$this->db->limit(1);
			$rs = $this->db->get('admin_user');
			if (!$rs || $rs->num_rows() !== 1) {
				redirect("welcome");
			}

			$user = $rs->row_array();

			$_SESSION['ADMIN_ID'] = $user['admin_user_id'];
			$_SESSION['ADMIN_USERNAME'] = $user['username'];
			$_SESSION['ADMIN_NAME'] = $user['first_name'] . ' ' . $user['last_name'];

			$url = "user";
			if ($this->session->userdata('REDIR_URL')) {
				$url = $this->session->userdata('REDIR_URL');
				$this->session->unset_userdata('REDIR_URL');
			}

			redirect($url);
		}
	}

	function index() {
		//Check For Host Login
		$user = $this->userauth->checkAuth();
		if (!$user) {
			redirect("user/login");
		}

		$this->meta->setTitle('My Account - {SITE_NAME}');

		//Render View
		$shell = array();
		$inner['user'] = $user;
		$shell['contents'] = $this->view->load("user/dashboard", $inner, TRUE);
		$this->load->view("themes/" . THEME . "/templates/default", $shell);
	}

	function lostpasswd() {
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->library('encryption');
		$this->load->helper('string');
		$this->load->library('parser');
		$this->load->library('email');

		//validation check
		$this->form_validation->set_rules('username', 'Username', 'is_string|trim|required');
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		//Meta
		$this->meta->setTitle('Forgot Password - {SITE_NAME}');

		if ($this->form_validation->run() == FALSE) {

			$inner = array();
			$shell = array();
			$shell['contents'] = $this->view->load("user/lostpasswd-form", $inner, TRUE);
			$this->load->view("themes/" . THEME . "/templates/default", $shell);
		} else {
			$this->issuePassword($this->input->post('username', TRUE));

			header("location: " . base_url() . "welcome/password_sent/");
			exit();
		}
	}

	function issuePassword($username) {
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->library('encryption');
		$this->load->helper('string');
		$this->load->library('parser');
		$this->load->library('email');

		$this->db->where('username', $username);
		$this->db->where('user_is_active', 1);
		$rs = $this->db->get('admin_user');
		if ($rs && $rs->num_rows() == 1) {
			$user = $rs->row_array();
			$random_key = time() . random_string('alnum', 10);
			$random_key = sha1($random_key);

			$data = array();
			$data['reset_passwd_key'] = $random_key;
			$this->db->where('admin_user_id', $user['admin_user_id']);

			$status = $this->db->update('admin_user', $data);
			if ($status) {
				$emailData = array();
				$emailData['DATE'] = date("jS F, Y");
				$emailData['NAME'] = $user['username'];
				$emailData['EMAIL'] = $user['email'];
				$emailData['RESET_PASSWD_KEY'] = base_url() . "user/reset_password/$random_key";
				log_message('error', 'Forget password Link: ' . $emailData['RESET_PASSWD_KEY']);

				$emailBody = $this->parser->parse('modules/user/emails/recover-password-email', $emailData);
				//	$emailBody = $this->view->load('user/emails/recover-password-email', $emailData);

				$this->email->initialize($this->config->item('EMAIL_CONFIG'));
				//	$this->email->from('info@smgstaging.com', 'info@smgstaging.com');
				$this->email->from('default@test.webpackt.com');
				$this->email->to($user['email'], true);
				$this->email->subject(config_item('SITE_NAME') . ' - Recover Password');
				$this->email->message($emailBody);
				$status = $this->email->send();


				if ($status) {
					$this->session->set_flashdata('SUCCESS', 'email_sent');
					redirect("user/lostpasswd");
					exit();
				}
			}
			$this->session->set_flashdata('error', 'email_not_sent');
			redirect("user");
			exit();
		}

		$this->session->set_flashdata('error', 'email_not_found');
		redirect("user");
		exit();
	}

	function reset_password($reset_passwd_key = false) {
		$this->load->library('encryption');
		$this->load->library('form_validation');
		$this->load->helper('form');
		//$this->load->model('user/Adminusermodel');

		$this->meta->setTitle('Recover Password - {SITE_NAME}');

		$this->db->where('reset_passwd_key', $reset_passwd_key);
		$rs = $this->db->get('admin_user');
		$user = $rs->row_array();

		$this->form_validation->set_rules('password_real', 'Password', 'trim|min_length[3]|matches[confirm_password_real]|required');
		$this->form_validation->set_rules('confirm_password_real', 'Confirm-Password', 'trim|min_length[3]|required');
		$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$shell = array();
			$inner['reset_passwd_key'] = $reset_passwd_key;
			$inner['user'] = $user;
			$shell['contents'] = $this->view->load("user/reset-password-form", $inner, TRUE);
			$this->load->view("themes/" . THEME . "/templates/default", $shell);
		} else {
			$data = array();
			if ($this->input->post('password_real')) {
				$data['passwd'] = password_hash($this->input->post('password_real', true), PASSWORD_BCRYPT);
			}
			$this->db->where('admin_user_id', $user['admin_user_id']);
			$status = $this->db->update('admin_user', $data);

			if ($status) {
				$this->session->set_flashdata('SUCCESS', 'password_updated');
				redirect("user");
				exit();
			}

			$this->load->view("error");
		}
	}

	function logout() {
		$this->session->unset_userdata('ADMIN_ID');
		$this->session->unset_userdata('ADMIN_USERNAME');
		$this->session->unset_userdata('ADMIN_NAME');
		redirect('/');
	}

}
