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
	
	public function forums($str)
	{
        $data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
        $data['breadcrumbs'] = array(
            array('Search')
        );

        $data['title'] = 'Search Results';

        $data['topics'] = $this->Search_model->getTopics(0, $str);

        $this->load->view('search/forum', $data);
	}
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */