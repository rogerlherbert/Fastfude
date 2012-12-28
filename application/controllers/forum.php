<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Forum extends CI_Controller
{
	function __construct() 
	{
		parent::__construct();
	
		$this->load->model('Forum_model');
		// $this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		$this->load->helper('date');

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['forums'] = $this->Forum_model->getForums();
		$data['topics'] = $this->Forum_model->getRecentTopics();

		$data['title'] = "Fastfude - Northern Ireland's Music Scene";

		$this->load->view('forum/index', $data);
	}

	public function watchlist()
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}
		
		$this->load->helper('date');
	
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['forums'] = $this->Forum_model->getForums();
		$data['topics'] = $this->Forum_model->getWatchedTopics($this->session->userdata('user_id'));

		$data['title'] = "Topics you're watching";

		$this->load->view('forum/watchlist', $data);
	}
	
	public function id($id)
	{
		if (!preg_match('/^[0-9]+$/', $id)) 
		{
			show_error('Bad forum id');
		}

		$this->load->helper('date');

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['forums'] = $this->Forum_model->getForums();
		$data['topics'] = $this->Forum_model->getRecentTopics($id);
		$data['title'] = $data['forums'][$id];

		$this->load->view('forum/id', $data);
	}
}
