<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Home extends CI_Controller
{
	function __construct() 
	{
		parent::__construct();
	
		$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		$this->load->model('Forum_model');
		$data['topics'] = $this->Forum_model->getRecentTopics();

		$this->load->view('home/index', $data);
	}
}
