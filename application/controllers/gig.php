<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gigs extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('Gig_model');
		$this->output->enable_profiler(TRUE);
	}
	
	public function index()
	{
		# code...
	}
}