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
		$this->db->order_by('topic_count', 'RANDOM');
		$this->db->limit(50);
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
	
	public function getTagIDs(array $tags)
	{
		if (count($tags) == 0) 
		{
			return null;
		}

		$this->db->select('id');
		$this->db->where_in('stub', $tags);

		$query = $this->db->get('tags');

		if ($query->num_rows() > 0) 
		{
			$ids = array();

			foreach ($query->result() as $row) 
			{
				$ids[] = $row->id;
			}

			return $ids;
		}
	}
	
	public function writeToTags($tag_str)
	{
		$tags = array();
		$tag_str = preg_replace('/[^a-z0-9 \-]+/i', '', $tag_str);
		$min_length = 4;

		if (mb_strlen($tag_str) >= $min_length) 
		{
			$words = array_unique(str_word_count(strtolower($tag_str), 1));

			foreach ($words as $word) 
			{
				if (mb_strlen($word) < $min_length) 
				{
					continue;
				}

				$insert_query = $this->db->insert_string('tags', array('stub' => $word));
				$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
				$this->db->query($insert_query);

				$tags[] = $word;
			}
		}

		return $tags;
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