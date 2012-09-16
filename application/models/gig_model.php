<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Gig
*/
class Gig_model extends CI_Model
{
	public function getGigByTopicID($topic_id)
	{
		$query = $this->db->get_where('gigs', array('topic_id' => $topic_id));
		
		if ($query->num_rows() > 0) {
			return $query->row();
		}
	}

	public function addGig($topic_id, $start_time, $title, $location, $reference_token, $lineup)
	{
		$fields = array(
			'topic_id' => $topic_id,
			'start_time' => date('Y-m-d h:i:s', $start_time),
			'title' => $title,
			'location' => $location,
			'reference_token' => $reference_token,
			'lineup' => $lineup
		);

		$this->db->insert('gigs', $fields);

		return $this->db->insert_id();
	}
}