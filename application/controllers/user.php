<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class User extends CI_Controller
{

	function __construct() 
	{
		parent::__construct();

		// $this->output->enable_profiler(TRUE);
		$this->load->model('User_model');
	}

	public function id($id)
	{
		if (!preg_match('/^[0-9]+$/', $id)) 
		{
			show_error('Bad user id');
		}

		$data['profile'] = $this->User_model->getUser($id);

		if (is_null($data['profile'])) 
		{
			show_404();
		}

		// muted users
		if ($this->session->userdata('user_id')) 
		{
			$data['muted'] = $this->User_model->getMutedUsers($this->session->userdata('user_id'));
		}
		
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['title'] = $data['profile']->username;

		$this->load->view('user/id', $data);
	}
	
	public function posts($id, $yearmonth = NULL)
	{
		if (!preg_match('/^[0-9]+$/', $id)) 
		{
			show_error('Bad user id');
		}

		$data['profile'] = $this->User_model->getUser($id);
		
		if (is_null($data['profile'])) 
		{
			show_404();
		}

		if (isset($yearmonth)) 
		{
			if (!preg_match('/^[0-9]{4}-[0-9]{1,2}+$/', $yearmonth)) 
			{
				show_error('Date should be in yyyy-mm format');
			}

			// show post list for the month
			$ym_params = explode('-', $yearmonth);

			$data['posts'] = $this->User_model->getPostsByMonth($id, $ym_params[0], $ym_params[1]);
			$data['bodyclass'] = strtolower(__CLASS__ . ' user_posts');
			$data['title'] = $data['profile']->username .' posts for '. $ym_params[0] .'-'. $ym_params[1];

			$this->load->view('user/posts', $data);
		}
		else
		{
			// show archive table
			$data['archive'] = $this->User_model->getPostsArchive($id);
			$data['bodyclass'] = strtolower(__CLASS__ . ' archive');
			$data['title'] = $data['profile']->username .' posts';
			
			$this->load->view('user/archive', $data);
		}
	}

	public function register()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|strtolower|required|valid_email');
		
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['title'] = "Register";

		if ($this->form_validation->run() == FALSE)
		{
			// first load or failed form validation
			$this->load->view('user/register', $data);
		}
		else
		{
			// create temp user and send email
			$this->User_model->createPendingUser($this->input->post('email'));
			$this->load->view('user/register_confirm', $data);
		}
	}

	public function confirm($auth_key)
	{
		$email = $this->User_model->getPendingEmail($auth_key);

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);

		if (!$email)
		{
			$data['title'] = "Onoes!";
			$this->load->view('user/register_auth', $data);
		}
		else
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[32]|is_unique[users.username]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|matches[passconf]');
			$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|required');
			
			if ($this->form_validation->run() == FALSE)
			{
				$data['title'] = "Pick a username and password";
				// first load or failed form validation
				$this->load->view('user/confirm', $data);
			}
			else
			{
				// create user and sign in
				$user_id = $this->User_model->createUser($this->input->post('username'), $this->input->post('password'), $email);
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

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);

		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "Sign In";
			// failed form validation
			$this->load->view('user/sign_in', $data);
		}
		else
		{
			// sign in user
			$user_id = $this->User_model->getUserID($this->input->post('username'), $this->input->post('password'));
			
			if ($user_id) 
			{
				$user = $this->User_model->getUser($user_id);

				$this->session->set_userdata('user_id', $user_id);
				$this->session->set_userdata('username', $user->username);
				$this->session->set_userdata('gravatar_id', $user->gravatar_id);

				redirect('/');
			}
			else
			{
				$data['title'] = "Onoes!";

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
	
	public function forgot()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', 'Username', 'required');

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);

		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "Forgot Password";
			// failed form validation
			$this->load->view('user/forgot', $data);
		}
		else
		{
			if ($user = $this->User_model->getUserByName($this->input->post('username'))) 
			{
				$this->User_model->createPasswordResetKey($user->id);
			}
			$data['title'] = "Check Your Email";

			$this->load->view('user/forgot_check', $data);
		}
	}
	
	public function recover($key)
	{
		$user_id = $this->User_model->isValidRecoveryKey($key);

		if ($user_id === FALSE) 
		{
			show_404();
		}

		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['title'] = "Choose a new password";
			// failed form validation
			$this->load->view('user/recover', $data);
		}
		else
		{
			$this->User_model->resetPassword($user_id, $this->input->post('password'));
			redirect('user/sign_in');
		}
	}

	public function mute($id)
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}
		
		if (!preg_match('/^[0-9]+$/', $id)) 
		{
			show_error('Bad user id');
		}
		
		$this->User_model->muteUser($this->session->userdata('user_id'), $id);
		
		redirect('user/id/'.$id);
	}

	public function unmute($id)
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}
		
		if (!preg_match('/^[0-9]+$/', $id)) 
		{
			show_error('Bad user id');
		}
		
		$this->User_model->unmuteUser($this->session->userdata('user_id'), $id);

		redirect('user/id/'.$id);
	}
}
