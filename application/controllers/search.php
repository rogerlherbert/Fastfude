<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Search extends CI_Controller
{
	function __construct() 
	{
		parent::__construct();

		$this->load->model('Search_model');
		// $this->output->enable_profiler(TRUE);
	}
	
	public function index()
	{
		if ($this->input->post('type') && $this->input->post('q')) {
			redirect('search/'.$this->input->post('type').'/all/'.urlencode($this->input->post('q')));
		}
		else
		{
			show_error('dunno what to look for');
		}
	}

	public function forums($forum = 'all', $for)
	{
		$this->load->helper('date');

		$this->load->model('Forum_model');

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
		$data['forums'] = $this->Forum_model->getForums();

		$forum_id = array_search($forum, $data['forums']);

		if($forum_id !== FALSE)
		{
			$data['title'] = 'Search for \''.urldecode($for).'\'';
			$data['topics'] = $this->Search_model->getTopics($forum_id, urldecode($for));
		}
		else
		{
			show_error('No such forum');
		}

		$this->load->view('search/forum', $data);
	}
}
