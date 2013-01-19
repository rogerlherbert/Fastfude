<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		// $this->output->enable_profiler(TRUE);

		$this->load->model('User_model');
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

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
		$data['title'] = 'Messages';
		$data['messages'] = $this->Message_model->getAllMessages($this->session->userdata('user_id'));

		$this->load->view('message/index', $data);
	}

	public function with($user_id)
	{
		if (!preg_match('/^[0-9]+$/', $user_id)) 
		{
			show_error('Bad user id');
		}

		$user = $this->User_model->getUser($user_id);

		if (is_null($user)) 
		{
			show_error('No such user');
		}

		$this->Message_model->markConversationAsRead($user_id, $this->session->userdata('user_id'));

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
		$data['muted'] = $this->User_model->getMutedUsers($this->session->userdata('user_id'));
		$data['title'] = 'Messages with '.$user->username;
		$data['user'] = $user;
		$data['messages'] = $this->Message_model->getConversationWith($this->session->userdata('user_id'), $user_id);

		$this->load->view('message/with', $data);
	}

	public function to($user_id)
	{
		if (!preg_match('/^[0-9]+$/', $user_id)) 
		{
			show_error('Bad user id');
		}

		$user = $this->User_model->getUser($user_id);

		if (is_null($user)) 
		{
			show_error('No such user');
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('post_text', 'Post Text', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
			$data['title'] = 'Create A Message';
			$data['user'] = $user;
			$this->load->view('message/to', $data);
		}
		else
		{
			$this->Message_model->sendMessage($this->session->userdata('user_id'), $user_id, $this->input->post('post_text'));
			redirect('messages');
		}
	}
	
	public function reply()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('user_id', 'User ID', 'trim|required|is_natural_no_zero|callback_valid_userid');
		$this->form_validation->set_rules('post_text', 'Post Text', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
			$data['title'] = 'Reply To Message';
			$this->load->view('message/reply', $data);
		}
		else
		{
			$this->Message_model->sendMessage($this->session->userdata('user_id'), $this->input->post('user_id'), $this->input->post('post_text'));
			redirect('messages');
		}
	}
	
	public function _valid_userid($user_id)
	{
		$this->db->where('id', $user_id);

		if ($this->db->count_all_results('users') > 0) 
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('valid_userid', 'The user does not exist');
			return FALSE;
		}
	}
}

/* End of file message.php */
/* Location: ./application/controllers/message.php */
