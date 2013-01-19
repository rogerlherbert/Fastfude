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

		$this->output->cache(1440);
		$this->output->set_content_type('text/xml');
	}

	public function index()
	{
		$data['sitemaps'] = $this->Forum_model->getSitemapIndex();

		$this->load->view('sitemap/index', $data);
	}
	
	public function topics($year)
	{
		if (!preg_match('/^[0-9]{4}+$/', $year) || $year < 1997 || $year > date('Y'))
		{
			show_404();
		}
		
		$data['topics'] = $this->Forum_model->getSitemapYear($year);
		
		$this->load->view('sitemap/topics', $data);
	}
	
	public function wiki()
	{
		$this->load->model('Wiki_model');

		$data['wiki'] = $this->Wiki_model->getSitemapWiki();
		
		$this->load->view('sitemap/wiki', $data);
	}
}

/* End of file sitemap.php */
/* Location: ./application/controllers/sitemap.php */