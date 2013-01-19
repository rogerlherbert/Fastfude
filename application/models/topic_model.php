<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Topic_model extends CI_Model
{
	public function getTopic($topic_id)
	{
		$query = $this->db->get_where('topics', array('id' => $topic_id));
	
		if ($query->num_rows() > 0) 
		{
			return $query->row();
		}
	}

	public function getPosts($topic_id)
	{
		$this->db->select('p.id, p.user_id, u.username, MD5(u.email) as avatar_hash, (SELECT us.value FROM users_settings us WHERE us.user_id = u.id AND us.key = "avatar") as avatar_service, UNIX_TIMESTAMP(p.post_time) as post_time, UNIX_TIMESTAMP(p.edit_time) as edit_time, p.post_text');
		$this->db->from('posts p');
		$this->db->join('users u', 'u.id = p.user_id');
		$this->db->where('p.topic_id', $topic_id);
	
		$query = $this->db->get();
	
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
				switch ($row->avatar_service) {
					case 'gravatar':
						$row->avatar_url = 'http://www.gravatar.com/avatar/'.$row->avatar_hash.'?s=96&r=pg';
						break;
					
					case 'unicornify':
						$row->avatar_url = 'http://unicornify.appspot.com/avatar/'.$row->avatar_hash.'?s=96';
						break;
					
					default:
						$row->avatar_url = 'assets/img/avatar.png';
						break;
				}
			}

			return $query->result();
		}
	}

	public function getPost($id, $user_id = null)
	{
		$this->db->where('id', $id);
		
		if (isset($user_id)) {
			$this->db->where('user_id', $user_id);
		}

		$query = $this->db->get('posts');

		if ($query->num_rows() > 0) 
		{
			return $query->row();
		}
	}

	public function addTopic($forum_id, $user_id, $user_ip, $title, $post_text)
	{
		$fields = array(
			'forum_id' => $forum_id,
			'title' => $title,
			'user_id_first' => $user_id
		);

		$this->db->insert('topics', $fields);

		$topic_id = $this->db->insert_id();

		$this->addPost($topic_id, $user_id, $user_ip, $post_text);
		
		return $topic_id;
	}

	public function addPost($topic_id, $user_id, $user_ip, $post_text)
	{
		$ip_int = ip2long($user_ip);
	
		$fields = array(
			'topic_id' => $topic_id,
			'user_id' => $user_id,
			'user_ip' => $ip_int,
			'post_text' => $post_text
		);
	
		$this->db->insert('posts', $fields);
		
		$post_id = $this->db->insert_id();

		$this->updateTopic($topic_id);

		$this->notifyWatchers($topic_id);

		return $post_id;
	}
	
	public function editPost($post_id, $post_text)
	{
		$this->db->where('id', $post_id);
		$this->db->update('posts', array('post_text' => $post_text, 'edit_time' => date('Y-m-d H:i:s')));
	}
	
	public function flagPost($post_id, $user_id)
	{
		$insert_query = $this->db->insert_string('users_actions', array('user_id' => $user_id, 'action' => 'flag_post', 'object_id' => $post_id));
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);

		$this->db->query($insert_query);
	}

	public function updateTopic($topic_id)
	{
		// get last post data
		$this->db->select('id, user_id, post_time');
		$this->db->where('topic_id', $topic_id);
		$this->db->order_by('post_time', 'desc');
		$this->db->limit(1);

		$query_last = $this->db->get('posts');
		$last = $query_last->row();

		// get first post data
		$this->db->select('id, user_id, post_time');
		$this->db->where('topic_id', $topic_id);
		$this->db->order_by('post_time', 'asc');
		$this->db->limit(1);
		
		$query_first = $this->db->get('posts');
		$first = $query_first->row();


		$fields = array();

		$fields['post_id_last'] = $last->id;
		$fields['post_time_last'] = $last->post_time;
		$fields['user_id_last'] = $last->user_id;

		$fields['post_id_first'] = $first->id;
		$fields['post_time_first'] = $first->post_time;
		$fields['user_id_first'] = $first->user_id;

		// get reply count
		$this->db->where('topic_id', $topic_id);
		$fields['replies'] = $this->db->count_all_results('posts') - 1;

		// update!
		$this->db->update('topics', $fields, array('id' => $topic_id));
	}
	
	public function isWatched($topic_id, $user_id)
	{
		$this->db->where(array('user_id' => $user_id, 'key' => 'watch_topic', 'value' => $topic_id));
		$this->db->from('users_settings');

		if ($this->db->count_all_results() > 0) 
		{
			return TRUE;
		}

		return NULL;
	}
	
	public function getFlaggedPosts($topic_id)
	{
		$this->db->select('p.id');
		$this->db->join('users_actions a', 'a.object_id = p.id');
		$this->db->where('a.action', 'flag_post');
		$this->db->where('p.topic_id', $topic_id);
		$this->db->group_by('p.id');

		$query = $this->db->get('posts p');
		
		$posts = array();
		
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) 
			{
				$posts[] = $row->id;
			}
		}

		return $posts;
	}
	
	public function notifyWatchers($topic_id)
	{
		$this->db->select('user_id');
		$this->db->where(array('key' => 'watch_topic', 'value' => $topic_id));

		$query_1 = $this->db->get('users_settings');
		
		if ($query_1->num_rows() > 0) 
		{
			$in = array();

			foreach($query_1->result() as $user) 
			{
				$in[] = $user->user_id;
			}

			$this->db->select('id, email');
			$this->db->where_in('id', $in);
			$query_2 = $this->db->get('users');

			if ($query_2->num_rows() > 0) 
			{
				$bcc = array();

				foreach ($query_2->result() as $email) 
				{
					$bcc[] = $email->email;
				}
				
				$this->load->library('email');
				
				$this->email->from('notifications@fastfude.org', 'Fastfude');
				$this->email->to('notifications@fastfude.org'); 
				$this->email->bcc($bcc); 
				
				$this->email->subject('x replied to a topic you watch on Fastfude');
				$this->email->message('Testing the email class.');	
				
				$this->email->send();

			}
		}
	}
	
	public function eraseUserIPData($user_id)
	{
		$this->db->set('user_ip', 0);
		$this->db->where('user_id', $user_id);
		$this->db->update('posts');
	}
}

/* End of file topic_model.php */
/* Location: ./application/models/topic_model.php */