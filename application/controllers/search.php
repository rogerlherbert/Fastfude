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
		echo 'TODO :)';
	}
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */