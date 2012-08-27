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
		$data['topic'] = $this->Topic_model->getTopic($id);
		
		if (is_null($data['topic'])) {
			show_404();
		}

		$data['posts'] = $this->Topic_model->getPosts($id);

		$this->load->view('topic/id', $data);
	}
}
