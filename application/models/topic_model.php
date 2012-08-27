<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Topic_model extends CI_Model
{
	public function getTopic($topic_id)
	{
		$query = $this->db->get_where('topics', array('id' => $topic_id));
	
		if ($query->num_rows() > 0) {
			return $query->row();
		}
	}

	public function getPosts($topic_id)
	{
		$this->db->select('p.id, p.user_id, u.username, MD5(u.email) as gravatar_id, UNIX_TIMESTAMP(p.post_time) as post_time, UNIX_TIMESTAMP(p.edit_time) as edit_time, p.post_text');
		$this->db->from('posts p');
		$this->db->join('users u', 'u.id = p.user_id');
		$this->db->where('p.topic_id', $topic_id);
	
		$query = $this->db->get();
	
		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}
}