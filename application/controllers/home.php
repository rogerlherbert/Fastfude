<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function index()
	{
		$data['bodyclass'] = 'home';
		$data['title'] = 'Fastfude';

		$this->load->view('home/index', $data);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */