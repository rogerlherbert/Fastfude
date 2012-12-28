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
		$this->db->select('p.id, p.user_id, u.username, MD5(u.email) as gravatar_id, UNIX_TIMESTAMP(p.post_time) as post_time, UNIX_TIMESTAMP(p.edit_time) as edit_time, p.post_text');
		$this->db->from('posts p');
		$this->db->join('users u', 'u.id = p.user_id');
		$this->db->where('p.topic_id', $topic_id);
	
		$query = $this->db->get();
	
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
	}

	public function getPost($id)
	{
		$query = $this->db->get_where('posts', array('id' => $id));

		if ($query->num_rows() > 0) 
		{
			return $query->row();
		}
	}

	public function addTopic($forum_id, $user_id, $title, $post_text)
	{
		$fields = array(
			'forum_id' => $forum_id,
			'title' => $title,
			'user_id_first' => $user_id
		);

		$this->db->insert('topics', $fields);

		$topic_id = $this->db->insert_id();

		$this->addPost($topic_id, $user_id, $post_text);
		
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
	
	public function watchTopic($topic_id, $user_id)
	{
		$this->db->insert('topics_watchlist', array('topic_id' => $topic_id, 'user_id' => $user_id));
	}

	public function unwatchTopic($topic_id, $user_id)
	{
		$this->db->delete('topics_watchlist', array('topic_id' => $topic_id, 'user_id' => $user_id));
	}
	
	public function isWatched($topic_id, $user_id)
	{
		$this->db->where(array('topic_id' => $topic_id, 'user_id' => $user_id));
		$this->db->from('topics_watchlist');

		if ($this->db->count_all_results() > 0) 
		{
			return TRUE;
		}

		return FALSE;
	}
	
	public function notifyWatchers($topic_id)
	{
		$this->db->select('user_id');
		$query_1 = $this->db->get_where('topics_watchlist', array('topic_id' => $topic_id));
		
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
}