<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Home extends CI_Controller
{

	public function index()
	{
		$this->output->enable_profiler(TRUE);
		
		if ($this->session->userdata('user_id')) {
			echo "logged in as ". $this->session->userdata('user_id'). anchor('user/sign_out', "sign out now");
		} else {
			echo "not logged in. ". anchor('user/sign_in', "sign in now") ." or ". anchor('user/register', "register a new user");
		}
	}
}
