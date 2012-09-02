<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class User extends CI_Controller
{

	function __construct() 
	{
		parent::__construct();

		$this->output->enable_profiler(TRUE);
		$this->load->model('User_model');
	}

	public function id($id)
	{
		if (!preg_match('/^[0-9]+$/', $id)) {
			show_error('Bad user id');
		}

		$data['profile'] = $this->User_model->getUser($id);

		if (is_null($data['profile'])) {
			show_404();
		}

		$this->load->view('user/id', $data);
	}

	public function register()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|strtolower|required|valid_email');
		
		if ($this->form_validation->run() == FALSE)
		{
			// first load or failed form validation
			$this->load->view('user/register');
		}
		else
		{
			// create temp user and send email
			$this->User_model->createPendingUser($this->input->post('email'));
			$this->load->view('user/register_confirm');
		}
	}

	public function confirm($auth_key)
	{
		$email = $this->User_model->getPendingEmail($auth_key);

		if (!$email)
		{
			$this->load->view('user/register_auth');
		}
		else
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|matches[passconf]');
			$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|required');
			
			if ($this->form_validation->run() == FALSE)
			{
				// first load or failed form validation
				$this->load->view('user/confirm');
			}
			else
			{
				// create user and sign in
				$input = array_merge($this->input->post(), array('email' => $email));

				$user_id = $this->User_model->createUser($input);
				$this->session->set_userdata('user_id', $user_id);

				redirect('/');
			}
		}
	}

	public function sign_in()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			// failed form validation
			$this->load->view('user/sign_in');
		}
		else
		{
			// sign in user
			$user_id = $this->User_model->getUserID($this->input->post('username'), $this->input->post('password'));
			
			if ($user_id) 
			{
				$this->session->set_userdata('user_id', $user_id);
				redirect('/');
			}
			else
			{
				// user/pass not found in DB
				$data['error'] = "That username & password combination is not correct.";
				$this->load->view('user/sign_in', $data);
			}

		}
	}
	
	public function sign_out()
	{
		$this->session->sess_destroy();
		redirect('/');
	}
	
	public function mute($id)
	{
		if (!$this->session->userdata('user_id')) {
			redirect('user/sign_in');
		}
		
		$this->User_model->muteUser($this->session->userdata('user_id'), $id);
	}

	public function unmute($id)
	{
		if (!$this->session->userdata('user_id')) {
			redirect('user/sign_in');
		}
		
		$this->User_model->unmuteUser($this->session->userdata('user_id'), $id);
	}
}
