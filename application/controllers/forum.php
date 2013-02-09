<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Forum extends CI_Controller
{
	function __construct() 
	{
		parent::__construct();
	
		$this->load->model('Forum_model');
		$this->load->helper('date');
	}

	public function index()
	{
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
		$data['forums'] = $this->Forum_model->getForums();
		$data['topics'] = $this->Forum_model->getRecentTopics();

		$data['title'] = "Fastfude - Northern Ireland's Music Scene";

		$this->load->view('forum/index', $data);
	}

	public function watchlist()
	{
		if (!$this->session->userdata('user_id')) 
		{
			redirect('user/sign_in');
		}
	
		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
		$data['forums'] = $this->Forum_model->getForums();
		$data['topics'] = $this->Forum_model->getWatchedTopics($this->session->userdata('user_id'));

		$data['title'] = "Topics you're watching";

		$this->load->view('forum/watchlist', $data);
	}
	
	public function id($id)
	{
		if (!preg_match('/^[0-9]+$/', $id)) 
		{
			show_error('Bad forum id');
		}

		$data['bodyclass'] = strtolower(__CLASS__ . ' ' . __FUNCTION__);
		$data['breadcrumbs'] = array(__CLASS__, __FUNCTION__);
		$data['forum'] = $this->Forum_model->getForum($id);
		$data['topics'] = $this->Forum_model->getRecentTopics($id);
		$data['title'] = $data['forum']['title'];

		$this->load->view('forum/id', $data);
	}

	public function archive($id, $yearmonth = NULL)
	{
		if (!preg_match('/^[0-9]+$/', $id)) 
		{
			show_error('Bad forum id');
		}

		$data['forum'] = $this->Forum_model->getForum($id);

		if ( ! isset($data['forum'])) 
		{
			show_404();
		}

		if (isset($yearmonth)) 
		{
			if (!preg_match('/^[0-9]{4}-[0-9]{1,2}+$/', $yearmonth)) 
			{
				show_error('Date should be in yyyy-mm format');
			}

			// show post list for the month
			$ym_params = explode('-', $yearmonth);

			$data['topics'] = $this->Forum_model->getTopicsByMonth($id, $ym_params[0], $ym_params[1]);
			$data['bodyclass'] = strtolower(__CLASS__ . ' archive');
			$data['breadcrumbs'] = array(__CLASS__, 'archive');
			$data['title'] = 'Topics started in '. date('M', $ym_params[1]) .' '. $ym_params[0];

			$this->load->view('forum/month', $data);
		}
		else
		{
			// show archive table
			$data['archive'] = $this->Forum_model->getTopicsArchive($id);
			$data['bodyclass'] = strtolower(__CLASS__ . ' archive');
			$data['breadcrumbs'] = array(__CLASS__, 'archive');
			$data['title'] = $data['forum']['title'] . ' Forum archive';
			
			$this->load->view('forum/archive', $data);
		}
	}

	public function feed($forum_id)
	{
		if (!preg_match('/^[0-9]+$/', $forum_id)) 
		{
			show_404();
		}

		$forums = $this->Forum_model->getForums();

		$data['entries'] = $this->Forum_model->getFeedTopics($forum_id);

		$data['feed'] = array(
			'title' => 'New ' . $forums[$forum_id] . ' topics',
			'forum_id' => $forum_id,
			'lastmod' => $data['entries'][0]->post_time,
			'category' => $forums[$forum_id]
		);
	
		$this->output->cache(60);
		$this->load->view('forum/feed', $data);
	}
}

/* End of file forum.php */
/* Location: ./application/controllers/forum.php */