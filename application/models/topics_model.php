<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Topics
*/
class Topics_model extends CI_Model
{
	public function getWatchedTopics($user_id)
	{
		$this->db->select('t.id, t.title, t.replies, UNIX_TIMESTAMP(t.post_time_last) as post_time_last');

		$this->db->select('u2.username as username_last, t.user_id_last');
		$this->db->join('users u2', 'u2.id = t.user_id_last', 'left outer');

		$this->db->join('users_settings us', 'us.value = t.id', 'left outer');
		$this->db->where('us.user_id = '.$user_id.' AND us.key = "watch_topic"');

		$this->db->order_by('t.post_id_last', 'desc');
		$this->db->limit(50);
		
		$query = $this->db->get('topics t');
		
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
	}
	
	public function getSitemapIndex()
	{
		$this->db->select('YEAR(post_time_first) as loc');
		$this->db->group_by('loc');
		$this->db->order_by('loc', 'asc');
		
		$query = $this->db->get('topics');

		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
	}
	
	public function getSitemapYear($year)
	{
		$this->db->select('id, DATE_FORMAT(post_time_last, "%Y-%m-%dT%TZ") as lastmod', FALSE);
		$this->db->where('YEAR(post_time_first)', $year);
		$this->db->order_by('post_time_first', 'asc');
		
		$query = $this->db->get('topics');
		
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
	}

	public function getFeedTopics($tag)
	{
		$this->db->select('t.id, t.title, DATE_FORMAT(t.post_time_first, "%Y-%m-%dT%TZ") as post_time, 
		DATE_FORMAT(p.edit_time, "%Y-%m-%dT%TZ") as post_edit_time, p.post_text, 
		t.user_id_first as user_id, u.username', FALSE);
		$this->db->join('posts p', 't.post_id_first = p.id');
		$this->db->join('users u', 't.user_id_first = u.id');
		$this->db->join('topics_tags tt', 'tt.topic_id = t.id', 'left');
		$this->db->join('tags ta', 'ta.id = tt.tag_id', 'left');
		$this->db->where('ta.stub', $tag);
		$this->db->order_by('post_time_first', 'desc');
		$this->db->limit(25,0);
		
		$query = $this->db->get('topics t');
		
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
	}
	
	public function getTopicsByMonth($tag, $year, $month)
	{
		$this->db->select('t.id, t.forum_id, t.title, t.replies, UNIX_TIMESTAMP(t.post_time_first) as post_time_first');

		$this->db->select('u1.username as username_first, t.user_id_first');
		$this->db->join('users u1', 'u1.id = t.user_id_first', 'left outer');

		$this->db->join('topics_tags tt', 'tt.topic_id = t.id', 'left');
		$this->db->join('tags ta', 'ta.id = tt.tag_id', 'left');

		$this->db->where('ta.stub', $tag);
		$this->db->where('YEAR(t.post_time_first)', $year);
		$this->db->where('MONTH(t.post_time_first)', $month);

		$this->db->order_by('t.post_time_first', 'asc');

		$query = $this->db->get('topics t');

		if ($query->num_rows > 0) 
		{
			return $query->result();
		}
	}
	
	public function getTopicsArchive($tag)
	{
		$this->db->select('YEAR(t.post_time_first) as theyear, MONTH(t.post_time_first) as themonth, COUNT(*) as topics');
		$this->db->group_by(array('theyear','themonth'));
		$this->db->order_by('theyear desc, themonth asc');
		
		$this->db->join('topics_tags tt', 'tt.topic_id = t.id', 'left');
		$this->db->join('tags ta', 'ta.id = tt.tag_id', 'left');

		$query = $this->db->get_where('topics t', array('ta.stub' => $tag));
		
		if ($query->num_rows > 0) 
		{
			$archive = array();

			for ($i = date('Y'); $i > 1999; $i--) 
			{ 
				$archive[$i] = array_pad(array(), 12, 0);
			}

			foreach ($query->result() as $row) 
			{
				$archive[$row->theyear][$row->themonth - 1] = (int) $row->topics;
			}

			return $archive;
		}
	}
}

/* End of file topics_model.php */
/* Location: ./application/models/topics_model.php */