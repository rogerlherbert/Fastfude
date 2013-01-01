<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Settings extends CI_Controller
{

	function __construct() 
	{
		parent::__construct();

		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}

		$this->load->model('User_model');
		$this->output->enable_profiler(TRUE);
	}

	public function avatar()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('avatar', 'Avatar', 'trim|alpha');
		
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
		$data['title'] = "Choose an Avatar";
		
		if ($this->form_validation->run() == FALSE)
		{
			// first load or failed form validation
			$this->load->view('settings/avatar', $data);
		}
		else
		{
			$this->User_model->setUserSetting($this->session->userdata('user_id'), 'avatar', $this->input->post('avatar'));
			// redirect('settings/avatar');
		}
	}
}