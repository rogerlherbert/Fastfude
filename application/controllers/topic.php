<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Topic extends CI_Controller
{
	function __construct() 
	{
		parent::__construct();

		$this->load->model('Topics_model');
		$this->load->model('Topic_model');
		// $this->output->enable_profiler(TRUE);
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

		$this->load->model('Gig_model');
		$data['gig'] = $this->Gig_model->getGigByTopicID($id);

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(
			array(__CLASS__)
		);

		$data['canonical'] = 'topic/id/'. $id;
		$data['title'] = $data['topic']->title;
		$data['posts'] = $this->Topic_model->getPosts($id);
		$data['flagged'] = $this->Topic_model->getFlaggedPosts($id);

		if ($this->session->userdata('user_id')) 
		{
			$data['watch_status'] = $this->Topic_model->isWatched($id, $this->session->userdata('user_id'));

			// muted users
			$this->load->model('User_model');
			$data['muted'] = $this->User_model->getMutedUsers($this->session->userdata('user_id'));
		}
		else
		{
			$data['muted'] = array();
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

		$this->form_validation->set_rules('topic_id', 'Topic ID', 'trim|required|is_natural_no_zero|callback__is_not_locked');
		$this->form_validation->set_rules('post_text', 'Post Text', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['canonical'] = 'topic/id/'. $this->input->post('topic_id');
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['breadcrumbs'] = array(
				array(__CLASS__, 'topic/id/'.$this->input->post('topic_id')),
				array(__FUNCTION__)
			);

			$data['title'] = 'Reply To Topic';
			$this->load->view('topic/reply', $data);
		}
		else
		{
			$this->Topic_model->addPost($this->input->post('topic_id'), $this->session->userdata('user_id'), $this->input->ip_address(), $this->input->post('post_text'));

			redirect('/');
		}
	}
	
	public function edit_post($post_id)
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}
		
		if (!preg_match('/^[0-9]+$/', $post_id)) 
		{
			show_error('Bad post id');
		}
		
		$data['post'] = $this->Topic_model->getPost($post_id, $this->session->userdata('user_id'));
		
		if (is_null($data['post'])) 
		{
			show_404();
		}
		
		$this->load->library('form_validation');

		$this->form_validation->set_rules('post_text', 'Post Text', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['canonical'] = 'topic/id/'. $data['post']->topic_id;
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['breadcrumbs'] = array(
				array(__CLASS__, 'topic/id/'.$data['post']->topic_id),
				array('Edit Post ' . $post_id)
			);

			$data['title'] = 'Edit Post';
			$this->load->view('topic/edit_post', $data);
		}
		else
		{
			$this->Topic_model->editPost($post_id, $this->input->post('post_text'));
		
			redirect('topic/id/'.$data['post']->topic_id.'#post_'.$post_id);
		}
	}
	
	public function flag_post($post_id)
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}
		
		if (!preg_match('/^[0-9]+$/', $post_id)) 
		{
			show_error('Bad post id');
		}
		
		$data['post'] = $this->Topic_model->getPost($post_id);
		
		if (is_null($data['post'])) 
		{
			show_404();
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('post', 'Flag Post', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['canonical'] = 'topic/id/'. $data['post']->topic_id;
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['breadcrumbs'] = array(
				array(__CLASS__, 'topic/id/'.$data['post']->topic_id),
				array('Flag Post ' . $post_id)
			);

			$data['title'] = 'Flag Post';
			$this->load->view('topic/flag_post', $data);
		}
		else
		{
			$this->Topic_model->flagPost($post_id, $this->session->userdata('user_id'));
		
			redirect('topic/id/'.$data['post']->topic_id.'#post_'.$post_id);
		}
	}
	
	public function post_settings($post_id)
	{
		if (!preg_match('/^[0-9]+$/', $post_id)) 
		{
			show_error('Bad post id');
		}
		
		$data['post'] = $this->Topic_model->getPostSummary($post_id);
		
		if (is_null($data['post'])) 
		{
			show_404();
		}
		
		$data['canonical'] = 'topic/id/'. $data['post']->topic_id;
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(
			array(__CLASS__, 'topic/id/'.$data['post']->topic_id),
			array('Post Settings ' . $post_id)
		);

		$data['title'] = 'Post Settings';
		$this->load->view('topic/post_settings', $data);
	}
	
	public function create()
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('subject', 'Topic Subject', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('post_text', 'Post Text', 'trim|required|min_length[30]');

		if ($this->form_validation->run() == FALSE)
		{
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['breadcrumbs'] = array(array('Topics', 'topics'), array('create'));
			$data['title'] = 'Create A Topic';
			$this->load->view('topic/create', $data);
		}
		else
		{
			$this->Topic_model->addTopic($this->input->post('tags'), $this->session->userdata('user_id'), $this->input->ip_address(), $this->input->post('subject'), $this->input->post('post_text'));
			redirect('/');
		}
	}
	
	public function watch($topic_id)
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}

		$this->load->model('User_model');
		$this->User_model->setUserSetting($this->session->userdata('user_id'), 'watch_topic', $topic_id);

		redirect('topic/id/'.$topic_id);
	}
	
	public function unwatch($topic_id)
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}
	
		$this->load->model('User_model');
		$this->User_model->deleteUserSettings($this->session->userdata('user_id'), 'watch_topic', $topic_id);
		
		redirect('topic/id/'.$topic_id);
	}
	
	public function _is_not_locked($topic_id)
	{
		$this->db->where(array('id' => $topic_id, 'is_locked' => 0));
		$this->db->from('topics');
		
		if ($this->db->count_all_results() > 0) {
			return TRUE;
		}

		$this->form_validation->set_message('_is_not_locked', 'This topic is locked and can\'t be posted to');
		return FALSE;
	}
}

/* End of file topic.php */
/* Location: ./application/controllers/topic.php */