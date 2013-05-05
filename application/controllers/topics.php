<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Topics extends CI_Controller
{
	function __construct() 
	{
		parent::__construct();

		$this->load->model('Topics_model');
		$this->load->model('Tag_model');
		$this->load->helper('date');
	}

	public function index()
	{
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['canonical'] = 'topics';
		$data['tags'] = $this->Tag_model->getTags();
		$data['breadcrumbs'] = array(array(__CLASS__, 'topics'));
		$data['title'] = "Topics";

		$this->load->view('topics/index', $data);
	}
	
	public function tagged($tag)
	{
		if (!preg_match('/^[a-z0-9]+$/', $tag)) 
		{
			show_error('Bad tag');
		}

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['topics'] = $this->Tag_model->getTopicsByTag($tag);
		$data['title'] = 'Topics tagged "'.$tag.'"';
		$data['canonical'] = 'topics/tagged/'. $tag;
		$data['breadcrumbs'] = array(array(__CLASS__, 'topics'), array($tag));

		$this->load->view('topics/id', $data);
	}

	public function watchlist()
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}
	
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['canonical'] = 'topics/watchlist';
		$data['breadcrumbs'] = array(
			array(__CLASS__, 'topics'),
			array(__FUNCTION__)
		);

		$data['topics'] = $this->Topics_model->getWatchedTopics($this->session->userdata('user_id'));
		$data['title'] = "Topics you're watching";

		$this->load->view('topics/watchlist', $data);
	}
	
	public function archive($tag, $yearmonth = NULL)
	{
		if (!preg_match('/^[a-z0-9]+$/', $tag)) 
		{
			show_error('Bad tag');
		}

		if (isset($yearmonth)) 
		{
			if (!preg_match('/^[0-9]{4}-[0-9]{1,2}+$/', $yearmonth)) 
			{
				show_error('Date should be in yyyy-mm format');
			}

			// show post list for the month
			$ym_params = explode('-', $yearmonth);

			$data['topics'] = $this->Topics_model->getTopicsByMonth($tag, $ym_params[0], $ym_params[1]);
			$data['bodyclass'] = strtolower(__CLASS__ . ' archive');
			$data['canonical'] = 'topics/archive/' . $yearmonth;
			$data['breadcrumbs'] = array(
				array(__CLASS__, 'topics'),
				array($tag, 'topics/tagged/'.$tag),
				array(__FUNCTION__, 'topics/archive/'.$tag),
				array($yearmonth)
			);

			$data['title'] = 'Topics started in '. date('M', $ym_params[1]) .' '. $ym_params[0];

			$this->load->view('topics/month', $data);
		}
		else
		{
			// show archive table
			$data['archive'] = $this->Topics_model->getTopicsArchive($tag);
			$data['bodyclass'] = strtolower(__CLASS__ . ' archive');
			$data['canonical'] = 'topics/archive/'. $tag;
			$data['breadcrumbs'] = array(
				array(__CLASS__, 'topics'),
				array($tag, 'topics/tagged/'.$tag),
				array(__FUNCTION__)
			);
			$data['tag'] = $tag;
			$data['title'] = $tag . ' tag archive';
			
			$this->load->view('topics/archive', $data);
		}
	}

	public function feed($tag)
	{
		if (!preg_match('/^[a-z0-9]+$/', $tag)) 
		{
			show_error('Bad tag');
		}

		$data['entries'] = $this->Topics_model->getFeedTopics($tag);

		$data['feed'] = array(
			'title' => 'New topics tagged "' . $tag . '"',
			'tag' => $tag,
			'lastmod' => $data['entries'][0]->post_time,
			'category' => $tag
		);
	
		// $this->output->cache(60);
		$this->load->view('topics/feed', $data);
	}
}

/* End of file topics.php */
/* Location: ./application/controllers/topics.php */