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
		$data['canonical'] = 'user/id/'. $id;
		$data['breadcrumbs'] = array(
			array(__CLASS__)
		);

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
			$data['canonical'] = 'user/posts/'. $id . '/' . $yearmonth;
			$data['breadcrumbs'] = array(
				array(__CLASS__, '/'),
				array($data['profile']->username, 'user/id/'.$id),
				array(__FUNCTION__, 'user/id/'.$id.'/posts'),
				array($yearmonth)
			);

			$data['title'] = $data['profile']->username .' posts for '. $ym_params[0] .'-'. $ym_params[1];

			$this->load->view('user/posts', $data);
		}
		else
		{
			// show archive table
			$data['archive'] = $this->User_model->getPostsArchive($id);
			$data['bodyclass'] = strtolower(__CLASS__ . ' archive');
			$data['canonical'] = 'user/posts/'. $id;
			$data['breadcrumbs'] = array(
				array(__CLASS__, '/'),
				array($data['profile']->username, 'user/id/'.$id),
				array(__FUNCTION__)
			);

			$data['title'] = $data['profile']->username .' posts';
			
			$this->load->view('user/archive', $data);
		}
	}

	public function register()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|strtolower|required|valid_email');
		
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(
			array('Register')
		);

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
		$data['breadcrumbs'] = array(
			array('Confirm Registration')
		);


		if (!$email)
		{
			$data['title'] = "Onoes!";
			$this->load->view('user/register_auth', $data);
		}
		else
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[32]|is_unique[users.username]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|matches[passconf]|callback__is_valid_password');
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
		$data['breadcrumbs'] = array(
			array('Sign In')
		);


		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "Sign In";
			// failed form validation
			$this->load->view('user/sign_in', $data);
		}
		else
		{
			// check if user is signing in for first time and needs to migrate password to new encryption
			if ($user_id = $this->User_model->hasOldPassword($this->input->post('username'), $this->input->post('password')))
			{
				$this->User_model->resetPassword($user_id, $this->input->post('password'));
			}
			else
			{
				$user_id = $this->User_model->getUserID($this->input->post('username'), $this->input->post('password'));
			}

			// sign in user
			if ($user_id) 
			{
				$user = $this->User_model->getUser($user_id);

				$this->session->set_userdata('user_id', $user_id);
				$this->session->set_userdata('username', $user->username);
				$this->session->set_userdata('avatar_hash', $user->avatar_hash);
				$this->session->set_userdata($this->User_model->getUserSettings($user_id));

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
		$data['breadcrumbs'] = array(
			array('Forgot Password')
		);


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
		
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|matches[passconf]|callback__is_valid_password');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['breadcrumbs'] = array(
				array('Reset Password')
			);

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

	public function _is_valid_password($str)
	{
		if (in_array(strtolower($str), $this->User_model->getCommonPasswords())) {
			$this->form_validation->set_message('_is_valid_password', 'You shoudn\'t use common or easily-guessed passwords');
			return FALSE;
		}
		
		return TRUE;
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */