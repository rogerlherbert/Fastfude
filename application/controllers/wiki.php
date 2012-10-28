<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Wiki extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('Wiki_model');
		$this->output->enable_profiler(TRUE);
	}
	
	public function index()
	{
		$this->load->helper('date');
		
		$data['history'] = $this->Wiki_model->getRecentEdits();
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['title'] = 'Recent Wiki Edits';
		
		$this->load->view('wiki/index', $data);
	}
	
	public function page($stub, $edit_id = NULL)
	{
		if (!is_null($edit_id)) 
		{
			if (!preg_match('/^[0-9]+$/', $edit_id)) 
			{
				show_error('Bad edit id');
			}
			
			$data['page'] = $this->Wiki_model->getPageEdit($edit_id);
		}
		else
		{
			$data['page'] = $this->Wiki_model->getCurrentPage($stub);
		}

		if (is_null($data['page'])) 
		{
			show_404();
		}
		
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['title'] = $data['page']->title;

		$this->load->view('wiki/page', $data);
	}
	
	public function history($stub)
	{
		$this->load->helper('date');

		$data['page'] = $this->Wiki_model->getCurrentPage($stub);
		
		if (is_null($data['page'])) 
		{
			show_404();
		}

		$data['history'] = $this->Wiki_model->getPageHistory($data['page']->page_id);

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['title'] = 'Edit history of '.$data['page']->title;
		
		$this->load->view('wiki/history', $data);
	}
}
