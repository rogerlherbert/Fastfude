<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Topic extends CI_Controller
{
	function __construct() 
	{
		parent::__construct();

		$this->load->model('Topic_model');
		$this->output->enable_profiler(TRUE);
	}

	public function id($id)
	{
		if (!preg_match('/^[0-9]+$/', $id)) 
		{
			show_error('Bad topic id');
		}
		
		$data['topic'] = $this->Topic_model->getTopic($id);
		
		if (is_null($data['topic'])) 
		{
			show_404();
		}

		$data['posts'] = $this->Topic_model->getPosts($id);

		// muted users
		if ($this->session->userdata('user_id')) 
		{
			$this->load->model('User_model');
			$data['muted'] = $this->User_model->getMutedUsers($this->session->userdata('user_id'));
		}

		$this->load->view('topic/id', $data);
	}

	public function reply()
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('topic_id', 'Topic ID', 'trim|required|is_natural_no_zero');
		$this->form_validation->set_rules('post_text', 'Post Text', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('topic/reply');
		}
		else
		{
			$this->Topic_model->addPost($this->input->post('topic_id'), $this->session->userdata('user_id'), $this->input->post('post_text'));

			redirect('/');
		}
	}
}
