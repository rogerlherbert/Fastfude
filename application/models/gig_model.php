<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Gig
*/
class Gig_model extends CI_Model
{
	public function getGigByTopicID($topic_id)
	{
		$this->db->select('UNIX_TIMESTAMP(start_time) as start_time, gig_title, location, lineup');
		$query = $this->db->get_where('gigs', array('topic_id' => $topic_id));
		
		if ($query->num_rows() > 0) 
		{
			$gig = $query->row();
			
			if ($gig->lineup != '') 
			{
				$gig->lineup = unserialize($gig->lineup);
			}
			
			return $gig;
		}
	}

	public function addGig($topic_id, $start_time, $title, $location, $reference_token, $lineup)
	{
		$fields = array(
			'topic_id' => $topic_id,
			'start_time' => date('Y-m-d H:i:s', $start_time),
			'gig_title' => $title,
			'location' => $location,
			'reference_token' => $reference_token,
			'lineup' => serialize($this->parseLineupStr($lineup))
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

		// prefill days of calendar
		$calendar = array_pad(array(), $days, null);
		
		if ($query->num_rows() > 0) 
		{
			// insert each gig in calendar according to how many days away they are from now
			foreach ($query->result() as $gig) 
			{
				$timediff = $gig->start_time - time();
	
				$offset = ($timediff <= 0) ? 0 : ceil($timediff / 86400);

				if ($gig->lineup != '') 
				{
					$gig->lineup = implode(' + ', unserialize($gig->lineup));
				}

				$calendar[$offset][] = $gig;
			}
		}

		return $calendar;
	}

	public function getGigsByDate($date)
	{
		$this->db->select('t.id as topic_id, UNIX_TIMESTAMP(g.start_time) as start_time, g.gig_title, g.lineup, g.location, t.replies');
		$this->db->join('topics t', 'g.topic_id = t.id', 'left');
		$this->db->order_by('g.start_time', 'asc');
		$this->db->where('g.start_time LIKE', $date."%");
	
		$query = $this->db->get('gigs g');
	
		if ($query->num_rows() > 0) 
		{
	
			$result = $query->result();
	
			foreach ($result as $gig) 
			{
				if ($gig->lineup != '') 
				{
					$gig->lineup = implode(' + ', unserialize($gig->lineup));
				}
			}

			return $query->result();
		}
	}
	
	private function parseLineupStr($str)
	{
		if(strpos($str, '+') === FALSE)
		{
			return array($str);
		}
		else
		{
			$array = array();
			
			foreach (explode('+', $str) as $band) 
			{
				$trimmed = trim($band);
				
				if ($trimmed != '') 
				{
					$array[] = mb_strtolower($trimmed);
				}
			}

			return $array;
		}
	}
}