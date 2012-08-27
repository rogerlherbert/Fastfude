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
		$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		$this->load->helper('date');
		$data['topics'] = $this->Forum_model->getRecentTopics();

		$this->load->view('forum/index', $data);
	}
}
