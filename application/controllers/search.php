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
		$this->load->helper('date');
	}

	public function index()
	{
		$type = $this->input->post('type');
		$str = $this->input->post('q');

		$safe_types = array('topics');

		if ($str != '' && $type != '' && in_array($type, $safe_types)) {
			redirect("search/$type/$str");
		} else {
			show_error('I can\'t search that :(');
		}
	}

	public function topics($str)
	{
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(
			array('Search')
		);

		$data['topics'] = $this->Search_model->getTopics($str);
		$data['title'] = count($data['topics']) .' topics found matching "'. $str .'"';

		$this->load->view('search/topics', $data);
	}
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */