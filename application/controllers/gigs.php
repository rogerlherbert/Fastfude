<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gigs extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		// $this->output->enable_profiler(TRUE);
		$this->load->model('Gig_model');
	}

	function index()
	{
		/*
			TODO show next 7 days gigs, links to this month's archive and next month's for longer viewing
		*/
		$this->load->model('Forum_model');
		$this->load->helper('date');

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['canonical'] = 'gigs';
		$data['breadcrumbs'] = array(
			array(__CLASS__, '/')
		);

		$data['forums'] = $this->Forum_model->getForums();
		$data['title'] = 'Gig Calendar';
		$data['calendar'] = $this->Gig_model->getUpcomingGigs();

		$this->load->view('gigs/upcoming', $data);
	}

	/**
	 * Gigs happening on a given date
	 *
	 * @param string $date 
	 * @return void
	 * @author Roger Herbert
	 */
	public function on($date)
	{
		// topics by date created
		if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date)) {
			show_error('Bad gig date');
		}

		$this->load->model('Forum_model');

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['canonical'] = 'gigs/on/'.$date;
		$data['breadcrumbs'] = array(
			array(__CLASS__, 'gigs'),
			array($date)
		);

		$data['title'] = 'Gigs on '. DateTime::createFromFormat('Y-m-d', $date)->format('D jS M Y');
		$data['forums'] = $this->Forum_model->getForums();
		$data['gigs'] = $this->Gig_model->getGigsByDate($date);

		$this->load->view('gigs/on', $data);
	}

	public function create()
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}
	
		$this->load->library('form_validation');
	
		$this->form_validation->set_rules('start_time_1', 'Date', 'trim|required|callback__valid_date');
		$this->form_validation->set_rules('start_time_2', 'Time', 'trim|required|callback__valid_time');
		$this->form_validation->set_rules('location', 'Venue', 'trim|required');
		$this->form_validation->set_rules('lineup', 'Lineup', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('subject', 'Topic Subject', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('post_text', 'Post Text', 'trim|required|min_length[30]');

		if ($this->form_validation->run() == FALSE)
		{
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['breadcrumbs'] = array(
				array(__CLASS__, 'gigs'),
				array(__FUNCTION__)
			);

			$data['title'] = 'Create A Gig';
			$this->load->view('gigs/create', $data);
		}
		else
		{
			$this->load->model('Topic_model');

			$topic_id = $this->Topic_model->addTopic(8, $this->session->userdata('user_id'), $this->input->ip_address(), $this->input->post('subject'), $this->input->post('post_text'));
			$start_time = strtotime($this->input->post('start_time_1') . " " . $this->input->post('start_time_2'));

			$this->Gig_model->addGig($topic_id, $start_time, $this->input->post('subject'), $this->input->post('location'), '', $this->input->post('lineup'));

			redirect('/');
		}
	}
	
	public function edit($gig_id)
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}
	
		if (!preg_match('/^[0-9]+$/', $gig_id)) 
		{
			show_error('Bad gig id');
		}

		$data['gig'] = $this->Gig_model->getGig($gig_id);

		if (is_null($data['gig'])) 
		{
			show_error('No such gig');
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('start_time_1', 'Date', 'trim|required|callback__valid_date');
		$this->form_validation->set_rules('start_time_2', 'Time', 'trim|required|callback__valid_time');
		$this->form_validation->set_rules('location', 'Venue', 'trim|required');
		$this->form_validation->set_rules('lineup', 'Lineup', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('subject', 'Topic Subject', 'trim|required|min_length[4]');

		if ($this->form_validation->run() == FALSE)
		{
			$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
			$data['breadcrumbs'] = array(
				array(__CLASS__, 'gigs'),
				array(__FUNCTION__)
			);

			$data['title'] = 'Edit A Gig';
			$this->load->view('gigs/edit', $data);
		}
		else
		{
			$start_time = strtotime($this->input->post('start_time_1') . " " . $this->input->post('start_time_2'));

			$this->Gig_model->editGig($gig_id, $start_time, $this->input->post('subject'), $this->input->post('location'), '', $this->input->post('lineup'));

			redirect('topic/id/'.$data['gig']->topic_id);
		}
	}
	
	public function _valid_date($str)
	{
		if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $str)) {

			$segments = explode('-', $str);
			$unix = strtotime($str);

			if (checkdate($segments[1], $segments[2], $segments[0]) && 
				strtotime('midnight') <= $unix &&
				strtotime('+2 years') >= $unix) 
			{
				return TRUE;
			}
		}

		$this->form_validation->set_message('_valid_date', 'The %s field should be a near-future date in the format yyyy-mm-dd');
		return FALSE;
	}

	public function _valid_time($str)
	{
		if (preg_match('/^[0-9]{2}:[0-9]{2}$/', $str)) {
			
			$segments = explode(':', $str);
			
			if ($segments[0] >= 0 && 
				$segments[0] < 24 && 
				$segments[1] >= 0 && 
				$segments[1] < 60) 
			{
				return TRUE;
			}
		}

		$this->form_validation->set_message('_valid_time', 'The %s field should be a time in the 24-hour format hh:mm');
		return FALSE;
	}
}

/* End of file gigs.php */
/* Location: ./application/controllers/gigs.php */