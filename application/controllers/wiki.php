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
		// $this->output->enable_profiler(TRUE);
	}
	
	public function index()
	{
		$this->load->helper('date');
		
		$data['history'] = $this->Wiki_model->getRecentEdits();
		$data['canonical'] = 'wiki';
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(
			array(__CLASS__)
		);

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
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['breadcrumbs'] = array(
				array(__CLASS__, 'Wiki'),
				array('404')
			);

			$data['title'] = 'Wiki page not found';
			
			$this->output->set_status_header('404');
			$this->load->view('wiki/404', $data);
		}
		else
		{
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['canonical'] = 'wiki/page/'.$data['page']->stub;
			$data['breadcrumbs'] = array(
				array(__CLASS__, 'Wiki'),
				array($data['page']->title)
			);

			$data['title'] = $data['page']->title;
			
			$this->load->helper('markdown');
			
			$this->load->view('wiki/page', $data);
		}
	}
	
	public function create()
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Page Title', 'trim|required');
		$this->form_validation->set_rules('page_text', 'Wiki Text', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['breadcrumbs'] = array(
				array(__CLASS__, 'Wiki'),
				array('Create')
			);

			$data['title'] = 'Create A Wiki Page';
			$this->load->view('wiki/create', $data);
		}
		else
		{
			if ($page_id = $this->Wiki_model->addPage($this->input->post('title'))) {
				$this->Wiki_model->editPage($page_id, $this->session->userdata('user_id'), $this->input->post('page_text'));
				
				redirect('wiki');
			}
			else
			{
				show_error('A wiki page with that name already exists, edit that one instead!');
			}
		}
	}
	
	public function edit($edit_id)
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}

		if (!preg_match('/^[0-9]+$/', $edit_id)) 
		{
			show_error('Bad edit id');
		}
	
		$data['page'] = $this->Wiki_model->getPageEdit($edit_id);
		
		if (is_null($data['page'])) {
			show_404();
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Page Title', 'trim|required');
		$this->form_validation->set_rules('page_text', 'Page Text', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['canonical'] = 'wiki/page/'.$data['page']->stub;
			$data['breadcrumbs'] = array(
				array(__CLASS__, 'Wiki'),
				array($data['page']->title, 'wiki/page/'.$data['page']->stub),
				array('Edit')
			);

			$data['title'] = 'Edit this wiki page';
			$this->load->view('wiki/edit', $data);
		}
		else
		{
			$this->Wiki_model->editPage($data['page']->page_id, $this->session->userdata('user_id'), $this->input->post('page_text'));

			redirect('wiki');
		}
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
		$data['canonical'] = 'wiki/page/'. $stub;
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(
			array(__CLASS__, 'Wiki'),
			array($data['page']->title, 'wiki/page/'.$stub),
			array('History')
		);

		$data['title'] = 'Edit history of '.$data['page']->title;
		
		$this->load->view('wiki/history', $data);
	}
}

/* End of file wiki.php */
/* Location: ./application/controllers/wiki.php */