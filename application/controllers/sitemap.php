<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Sitemap extends CI_Controller
{
	function __construct() 
	{
		parent::__construct();

		$this->load->model('Forum_model');
		$this->load->helper('xml');
	}

	public function index()
	{
		$data['sitemaps'] = $this->Forum_model->getSitemapIndex();

		$this->output->set_content_type('text/xml');
		$this->load->view('sitemap/index', $data);
	}
	
	public function year($year)
	{
		if (!preg_match('/^[0-9]{4}+$/', $year)) 
		{
			show_error('Bad year');
		}
		
		$data['topics'] = $this->Forum_model->getSitemapYear($year);
		
		$this->output->set_content_type('text/xml');
		$this->load->view('sitemap/year', $data);
	}
}