<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Tag
*/
class Tag_model extends CI_Model
{
	public function getTags()
	{
		$this->db->select('ta.stub, COUNT(tt.tag_id) as topic_count');
		$this->db->join('tags ta', 'ta.id = tt.tag_id', 'left');
		$this->db->group_by('tt.tag_id');
		$this->db->order_by('topic_count', 'desc');
		$this->db->limit(25);
		$query = $this->db->get('topics_tags tt');
		
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
	}
	
	public function getTag($stub)
	{
		$this->db->where('stub', $stub);
		$query = $this->db->get('tags');
		
		if ($query->num_rows > 0) 
		{
			return $query->row();
		}
	}

	public function getTopicsByTag($stub)
	{
		$this->db->select('t.id, t.title, t.replies, UNIX_TIMESTAMP(t.post_time_last) as post_time_last');

		$this->db->join('topics_tags tt', 'tt.topic_id = t.id');
		$this->db->join('tags ta', 'ta.id = tt.tag_id');

		$this->db->select('u1.username as username_first, t.user_id_first');
		$this->db->join('users u1', 'u1.id = t.user_id_first', 'left outer');

		$this->db->select('u2.username as username_last, t.user_id_last');
		$this->db->join('users u2', 'u2.id = t.user_id_last', 'left outer');
		
		$this->db->where('ta.stub', $stub);
		
		$this->db->order_by('t.post_id_last', 'desc');
		$this->db->limit(50);

		$query = $this->db->get('topics t');

		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
	}
}

/* End of file tag_model.php */
/* Location: ./application/models/tag_model.php */