<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->output->enable_profiler(TRUE);

		$this->load->model('Message_model');
		
		// all these pages require a logged in user
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}
	}

	public function index()
	{
		$this->load->helper('date');

		$data['title'] = 'Private Messages';
		$data['messages'] = $this->Message_model->getAllMessages($this->session->userdata('user_id'));

		$this->load->view('message/index', $data);
	}

	public function with($user_id)
	{
		if (!preg_match('/^[0-9]+$/', $user_id)) 
		{
			show_error('Bad user id');
		}

		$this->load->model('User_model');

		$user = $this->User_model->getUser($user_id);
		/*
			TODO check user exists!
		*/

		$this->Message_model->markConversationAsRead($user_id, $this->session->userdata('user_id'));

		$data['muted'] = $this->User_model->getMutedUsers($this->session->userdata('user_id'));
		$data['title'] = 'Private Messages with '.$user->username;
		$data['user'] = $user;
		$data['messages'] = $this->Message_model->getConversationWith($this->session->userdata('user_id'), $user_id);

		$this->load->view('message/with', $data);
	}

	public function send($to_id)
	{
		if (!preg_match('/^[0-9]+$/', $to_id)) 
		{
			show_error('Bad user id');
		}
		
	}
}

/* End of file message.php */
/* Location: ./application/controllers/message.php */
