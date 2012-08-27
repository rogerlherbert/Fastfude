<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Forum
*/
class Forum_model extends CI_Model
{
	public function getRecentTopics()
	{
		$this->db->order_by('post_id_last', 'desc');
		$this->db->limit(100);
		$query = $this->db->get('topics');

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}
}