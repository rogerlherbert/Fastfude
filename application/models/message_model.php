<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Message
*/
class Message_model extends CI_Model
{

	public function getAllMessages($user_id)
	{
		$query = $this->db->query("SELECT 
				m.from_id as user_id, 
				u.username, 
				UNIX_TIMESTAMP(MAX(m.post_time)) as post_time, 
				m.is_read, 
				md5(email) as avatar_hash, 
				(SELECT us.value FROM users_settings us WHERE us.user_id = m.from_id AND us.key = 'avatar') as avatar_service,
				'from' as dir
			FROM private_messages m
			JOIN users u ON u.id = m.from_id
			WHERE m.to_id = $user_id
			GROUP BY m.from_id

			UNION SELECT 
				m.to_id as user_id, 
				u.username, 
				UNIX_TIMESTAMP(MAX(m.post_time)) as post_time, 
				m.is_read, 
				null as avatar_hash,
				null as avatar_service, 
				'to' as dir
			FROM private_messages m
			JOIN users u ON u.id = m.to_id
			WHERE m.from_id = $user_id
			GROUP BY m.to_id

			ORDER BY post_time DESC");

		if ($query->num_rows() > 0) 
		{

			$conv = array();

			foreach ($query->result() as $row) 
			{
				// already have a msg to/from this user?
				if (array_key_exists($row->user_id, $conv)) 
				{
					// this msg sooner than previous?
					if ($conv[$row->user_id]['post_time'] < $row->post_time) 
					{
						$conv[$row->user_id] = array(
							'username' => $row->username, 
							'post_time' => $row->post_time,
							'is_read' => $row->is_read,
							'avatar_url' => $this->_avatar_url($row->avatar_service, $row->avatar_hash),
							'dir' => $row->dir
						);
					}
				} 
				else 
				{
					// record this user msg
					$conv[$row->user_id] = array(
						'username' => $row->username, 
						'post_time' => $row->post_time,
						'is_read' => $row->is_read,
						'avatar_url' => $this->_avatar_url($row->avatar_service, $row->avatar_hash),
						'dir' => $row->dir
					);
				}
			}

			return $conv;
		}
	}

	public function getConversationWith($my_id, $user_id)
	{
		$this->load->library('encrypt');

		$query = $this->db->query("SELECT 
				m.id, 
				UNIX_TIMESTAMP(post_time) as post_time, 
				u.id as user_id, 
				u.username, 
				MD5(u.email) as avatar_hash, 
				(SELECT us.value FROM users_settings us WHERE us.user_id = u.id AND us.key = 'avatar') as avatar_service,
				m.post_text
			FROM private_messages m
			JOIN users u ON u.id = m.from_id
			WHERE m.to_id = $my_id AND m.from_id = $user_id

			UNION SELECT 
				m.id, 
				UNIX_TIMESTAMP(post_time) as post_time, 
				u.id as user_id, 
				u.username, 
				MD5(u.email) as avatar_hash, 
				(SELECT us.value FROM users_settings us WHERE us.user_id = u.id AND us.key = 'avatar') as avatar_service,
				m.post_text
			FROM private_messages m
			JOIN users u ON u.id = m.from_id
			WHERE m.to_id = $user_id AND m.from_id = $my_id

			ORDER BY post_time ASC");

		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) 
			{
				$row->post_text = $this->encrypt->decode($row->post_text);
				$row->avatar_url = $this->_avatar_url($row->avatar_service, $row->avatar_hash);
			}

			return $query->result();
		}
	}

	public function markConversationAsRead($from_id, $to_id)
	{
		$this->db->set('is_read', 1);
		$this->db->where(array('from_id' => $from_id, 'to_id' => $to_id));
		$this->db->update('private_messages');
	}
	
	public function markAllConversationsAsRead($to_id)
	{
		$this->db->set('is_read', 1);
		$this->db->where('to_id', $to_id);
		$this->db->update('private_messages');
	}

	public function sendMessage($from_id, $to_id, $post_text)
	{
		$this->load->library('encrypt');

		$this->db->insert('private_messages', array(
			'post_text' => $this->encrypt->encode($post_text),
			'from_id' => $from_id,
			'to_id' => $to_id
		));
	}

	public function getUserLastMessage($user_id)
	{
		$this->db->select('UNIX_TIMESTAMP(MAX(post_time)) as post_time');

		$query = $this->db->get_where('private_messages', array('from_id' => $user_id));

		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->post_time;
		}

		return null;
	}
	
	private function _avatar_url($service, $hash)
	{
		switch ($service) 
		{
			case 'gravatar':
				$avatar_url = 'http://www.gravatar.com/avatar/'.$hash.'?s=128&r=pg';
				break;
			
			case 'unicornify':
				$avatar_url = 'http://unicornify.appspot.com/avatar/'.$hash.'?s=128';
				break;
			
			default:
				$avatar_url = 'assets/img/avatar.png';
				break;
		}
		
		return $avatar_url;
	}
}

?>
