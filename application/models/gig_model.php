<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Gig
*/
class Gig_model extends CI_Model
{
	public function getGigByTopicID($topic_id)
	{
		$this->db->select('id, UNIX_TIMESTAMP(start_time) as start_time, gig_title, location, lineup');
		$query = $this->db->get_where('gigs', array('topic_id' => $topic_id));
		
		if ($query->num_rows() > 0) 
		{
			$gig = $query->row();
			
			if ($gig->lineup != '') 
			{
				$gig->lineup = json_decode($gig->lineup);
			}
			
			return $gig;
		}
	}
	
	public function getGig($id)
	{
		$this->db->select('id, topic_id, UNIX_TIMESTAMP(start_time) as start_time, gig_title, location, lineup');
		$query = $this->db->get_where('gigs', array('id' => $id));
		
		if ($query->num_rows() > 0) 
		{
			$gig = $query->row();
			
			if ($gig->lineup != '') 
			{
				$gig->lineup = implode(' + ', json_decode($gig->lineup));
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
			'lineup' => json_encode($this->parseLineupStr($lineup))
		);

		$this->db->insert('gigs', $fields);

		return $this->db->insert_id();
	}

	public function editGig($id, $start_time, $title, $location, $reference_token, $lineup)
	{
		$fields = array(
			'start_time' => date('Y-m-d H:i:s', $start_time),
			'gig_title' => $title,
			'location' => $location,
			'reference_token' => $reference_token,
			'lineup' => json_encode($this->parseLineupStr($lineup))
		);

		$this->db->where('id', $id);
		$this->db->update('gigs', $fields);
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
				$today = new DateTime('today');
				$gig_date = new DateTime('@'.$gig->start_time);

				$interval = $today->diff($gig_date);

				if ($gig->lineup != '') 
				{
					$gig->lineup = implode(' + ', json_decode($gig->lineup));
				}

				$calendar[$interval->days][] = $gig;
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
					$gig->lineup = implode(' + ', json_decode($gig->lineup));
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

/* End of file gig_model.php */
/* Location: ./application/models/gig_model.php */