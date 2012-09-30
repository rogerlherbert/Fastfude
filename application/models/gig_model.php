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
	
	public function getUpcomingGigs($days = 90)
	{
		$this->db->select('t.id as topic_id, UNIX_TIMESTAMP(g.start_time) as start_time, g.gig_title, g.lineup, g.location, t.replies');
		$this->db->join('topics t', 'g.topic_id = t.id', 'left');
		$this->db->order_by('g.start_time', 'asc');
		$this->db->where('g.start_time >= CURDATE()');
		$this->db->where('g.start_time < DATE_ADD(CURDATE(), INTERVAL '.$days.' DAY)');
	
		$query = $this->db->get('gigs g');
	
		if ($query->num_rows() > 0) {
	
			// prefill days of calendar
			$calendar = array_pad(array(), $days, null);
	
			// insert each gig in calendar according to how many days away they are from now
			foreach ($query->result() as $gig) {
				$timediff = $gig->start_time - time();
	
				$offset = ($timediff <= 0) ? 0 : $offset = floor($timediff / 86400);
	
				$calendar[$offset][] = $gig;
			}
	
			return $calendar;
		}
	}

	public function getGigsByDate($date)
	{
		$this->db->select('t.id as topic_id, UNIX_TIMESTAMP(g.start_time) as start_time, g.gig_title, g.lineup, g.location, t.replies');
		$this->db->join('topics t', 'g.topic_id = t.id', 'left');
		$this->db->order_by('g.start_time', 'asc');
		$this->db->where('g.start_time LIKE', $date."%");
	
		$query = $this->db->get('gigs g');
	
		if ($query->num_rows() > 0) {
	
			$result = $query->result();
	
			foreach ($result as $gig) {
				if ($gig->lineup != '') {
					$gig->lineup = unserialize($gig->lineup);
				}
			}
			return $query->result();
		}
	}
}