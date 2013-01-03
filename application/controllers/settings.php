<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Settings extends CI_Controller
{
	private $notifications;
	private $avatar_services;

	function __construct() 
	{
		parent::__construct();

		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}

		$this->load->model('User_model');
		$this->load->library('form_validation');

		$this->notifications = array(
			'watchlist' => 'replies to your watchlist',
			'messages' => 'new private messages'
		);

		$this->avatar_services = array(
			'none' => array('value' => '', 'url' => ''),
			'gravatar' => array('value' => 'gravatar', 'url' => 'http://www.gravatar.com/avatar/%s?s=96&r=pg'),
			'unicornify' => array('value' => 'unicornify', 'url' => 'http://unicornify.appspot.com/avatar/%s?s=96')
		);
		
		$this->output->enable_profiler(TRUE);
	}
	
	public function index()
	{
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__);
		$data['title'] = "Settings";

		$this->load->view('settings/index', $data);
	}

	public function avatar()
	{
		$this->form_validation->set_rules('avatar', 'Avatar', 'trim|alpha');
		
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "Choose an Avatar";
			$data['options'] = $this->avatar_services;

			$this->load->view('settings/avatar', $data);
		}
		else
		{
			$this->User_model->setUserSetting($this->session->userdata('user_id'), 'avatar', $this->input->post('avatar'));

			$this->session->unset_userdata('avatar');
			$this->session->set_userdata($this->User_model->getUserSettings($this->session->userdata('user_id')));

			redirect('settings');
		}
	}
	
	public function email()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
		$data['title'] = "Change Your Email Address";
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('settings/email', $data);
		}
		else
		{
			$this->User_model->createPendingUser($this->input->post('email'));
			$this->load->view('user/register_confirm', $data);
		}
	}
	
	public function email_confirm($auth_key)
	{
		if($email = $this->User_model->getPendingEmail($auth_key))
		{
			$this->User_model->changeEmail($this->session->userdata('user_id'), $email);
			$this->session->set_userdata('avatar_hash', md5($email));

			redirect('settings');
		}
		else
		{
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
			$data['title'] = "Onoes!";
			$this->load->view('user/register_auth', $data);
		}
	}
	
	public function username()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[32]|is_unique[users.username]');
		
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
	
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "Change Your Username";
			
			$this->load->view('settings/username', $data);
		}
		else
		{
			$this->User_model->changeUsername($this->session->userdata('user_id'), $this->input->post('username'));
			$this->session->set_userdata('username', $this->input->post('username'));

			redirect('settings');
		}
	}
	
	public function password()
	{
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|matches[passconf]|callback__is_valid_password');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|required');
				
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "Change Your Password";
			
			$this->load->view('settings/password', $data);
		}
		else
		{
			$this->User_model->resetPassword($this->session->userdata('user_id'), $this->input->post('password'));
		
			redirect('settings');
		}
	}
	
	public function notifications()
	{
		$this->form_validation->set_rules('notifications[]', 'Notifications', 'trim|alpha|callback__is_valid_notification_type');
		
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "Change Your Notifications";
			$data['options'] = $this->notifications;
			$data['settings'] = $this->User_model->getNotificationsSettings($this->session->userdata('user_id'));
			
			$this->load->view('settings/notifications', $data);
		}
		else
		{
			$notifications = ($this->input->post('notifications')) ? $this->input->post('notifications') : array();

			$this->User_model->changeNotifications($this->session->userdata('user_id'), $notifications);
			$this->session->unset_userdata('notifications');
			$this->session->set_userdata($this->User_model->getUserSettings($this->session->userdata('user_id')));

			redirect('settings');
		}
	}
	
	public function delete()
	{
		$this->form_validation->set_rules('confirm', 'Delete', 'trim|required');
		
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
		$data['title'] = "Delete your account";
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('settings/delete', $data);
		}
		else
		{
			$this->User_model->createPendingUser($this->User_model->getUserEmail($this->session->userdata('user_id')));
			$this->load->view('settings/delete_email', $data);
		}
	}
	
	public function delete_confirm($auth_key)
	{
		$email = $this->User_model->getPendingEmail($auth_key);

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
		$data['title'] = "Delete your account";
		
		if (!$email)
		{
			$data['title'] = "Onoes!";
			$this->load->view('user/register_auth', $data);
		}
		else
		{
			$this->form_validation->set_rules('confirm', 'Delete', 'trim|required');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('settings/delete_confirm', $data);
			}
			else
			{
				/*
				Arise! Arise, Riders of Theoden! 
				Fell deeds awake, fire and slaughter! 
				Spears shall be shaken! Shields shall be splintered! 
				A sword day! A red day! Ere the sun rises! 
				Ride now! Ride now! Ride!
				Ride for ruin, and the world’s ending! 
				Death! Death! Death! 
				*/
				
				$user_id = $this->session->userdata('user_id');
				
				// private messages
				$this->load->model('Message_model');
				$this->Message_model->deleteUserSentItems($user_id);
				
				// post IP addresses
				$this->load->model('Topic_model');
				$this->Topic_model->eraseUserIPData($user_id);
				$this->Topic_model->eraseWatchlist($user_id);
				
				// scrub user profile
				$this->User_model->deleteUserSettings($user_id);
				$this->User_model->eraseUserProfile($user_id);
				
				// destroy session
				$this->session->sess_destroy();
				redirect('/');
			}
		}
	}
	
	public function _is_valid_password($str)
	{
		if (in_array(strtolower($str), $this->User_model->getCommonPasswords())) 
		{
			$this->form_validation->set_message('_is_valid_password', 'You shoudn\'t use common or easily-guessed passwords');
			return FALSE;
		}
		
		return TRUE;
	}
	
	public function _is_valid_notification_type($str)
	{
		if ($str == '' || array_key_exists($str, $this->notifications)) 
		{
			return TRUE;
		}
		
		$this->form_validation->set_message('_is_valid_notification_type', "'$str'".' is not a valid notification type');
		return FALSE;
	}
}