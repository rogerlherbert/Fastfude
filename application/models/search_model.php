<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model
{
	public function getTopics($forum_id, $str)
	{
		$this->db->distinct();

		$this->db->select('t.id, t.forum_id, t.title, t.replies, UNIX_TIMESTAMP(t.post_time_last) as post_time_last');
		
		$this->db->join('posts p', 'p.topic_id = t.id', 'left outer');

		$this->db->select('u1.username as username_first, t.user_id_first');
		$this->db->join('users u1', 'u1.id = t.user_id_first', 'left outer');
		
		$this->db->select('u2.username as username_last, t.user_id_last');
		$this->db->join('users u2', 'u2.id = t.user_id_last', 'left outer');

		if ($forum_id > 0) 
		{
			$this->db->where('forum_id', $forum_id);
		}
		
		$this->db->where('p.post_text LIKE', '%'.$str.'%');
	
		$this->db->order_by('t.post_id_last', 'desc');
		$this->db->limit(50);
	
		$query = $this->db->get('topics t');
	
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
	}
}