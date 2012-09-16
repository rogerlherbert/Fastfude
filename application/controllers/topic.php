<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Topic extends CI_Controller
{
	function __construct() 
	{
		parent::__construct();

		$this->load->model('Forum_model');
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

		switch ($data['topic']->forum_id) {
			case 8:
				$this->load->model('Gig_model');
				$data['gig'] = $this->Gig_model->getGigByTopicID($id);
				break;

			default:
				# don't do nathin' so it is
				break;
		}

		$data['title'] = $data['topic']->title;
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
			$data['title'] = 'Reply To Topic';
			$this->load->view('topic/reply', $data);
		}
		else
		{
			$this->Topic_model->addPost($this->input->post('topic_id'), $this->session->userdata('user_id'), $this->input->post('post_text'));

			redirect('/');
		}
	}
	
	public function create()
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('forum_id', 'Forum ID', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('subject', 'Topic Subject', 'trim|required');
		$this->form_validation->set_rules('post_text', 'Post Text', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			$data['forums'] = $this->Forum_model->getForums();
			$data['title'] = 'Create A Topic';
			$this->load->view('topic/create', $data);
		}
		else
		{
			$this->Topic_model->addTopic($this->input->post('forum_id'), $this->session->userdata('user_id'), $this->input->post('subject'), $this->input->post('post_text'));
			redirect('/');
		}
	}
}
