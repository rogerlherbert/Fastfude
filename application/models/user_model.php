<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class User_model extends CI_Model
{

	public function getUser($id)
	{
		$this->db->select('id, username, MD5(email) as avatar_hash, (SELECT us.value FROM users_settings us WHERE us.user_id = u.id AND us.key = "avatar") as avatar_service, UNIX_TIMESTAMP(created) as created');
		$query = $this->db->get_where('users u', array('id' => $id));

		if ($query->num_rows > 0) 
		{
			$row = $query->row();

				switch ($row->avatar_service) 
				{
					case 'gravatar':
						$row->avatar_url = 'http://www.gravatar.com/avatar/'.$row->avatar_hash.'?s=128&r=pg';
						break;
					
					case 'unicornify':
						$row->avatar_url = 'http://unicornify.appspot.com/avatar/'.$row->avatar_hash.'?s=128';
						break;
					
					default:
						$row->avatar_url = 'assets/img/avatar.png';
						break;
				}

			return $row;
		}
	}
	
	public function getUserEmail($user_id)
	{
		$this->db->select('email');
		$query = $this->db->get_where('users', array('id' => $user_id));
		
		if ($query->num_rows > 0) 
		{
			$row = $query->row();
			
			return $row->email;
		}
	}

	public function getUserByName($username)
	{
		$this->db->select('id, username, MD5(email) as gravatar_id, UNIX_TIMESTAMP(created) as created');
		$query = $this->db->get_where('users', array('username' => $username));
	
		if ($query->num_rows > 0) 
		{
			return $query->row();
		}
	}
	
	public function getPostsByMonth($user_id, $year, $month)
	{
		$this->db->select('p.id, p.user_id, UNIX_TIMESTAMP(p.post_time) as post_time, UNIX_TIMESTAMP(p.edit_time) as edit_time, p.post_text, p.topic_id, t.title');
		$this->db->join('topics t', 't.id = p.topic_id');
		$this->db->order_by('post_time', 'desc');
		$this->db->where('p.user_id', $user_id);
		$this->db->where('YEAR(p.post_time)', $year);
		$this->db->where('MONTH(p.post_time)', $month);

		$query = $this->db->get_where('posts p');

		if ($query->num_rows > 0) 
		{
			return $query->result();
		}
	}
	
	public function getPostsArchive($user_id)
	{
		$this->db->select('YEAR(post_time) as theyear, MONTH(post_time) as themonth, COUNT(*) as posts');
		$this->db->group_by(array('theyear','themonth'));
		$this->db->order_by('theyear desc, themonth asc');

		$query = $this->db->get_where('posts', array('user_id' => $user_id));
		
		if ($query->num_rows > 0) 
		{
			$archive = array();

			for ($i = date('Y'); $i > 1999; $i--) 
			{ 
				$archive[$i] = array_pad(array(), 12, 0);
			}

			foreach ($query->result() as $row) 
			{
				$archive[$row->theyear][$row->themonth - 1] = (int) $row->posts;
			}

			return $archive;
		}
	}
	
	public function createPendingUser($email)
	{
		$this->load->helper('string');
		$auth_key = random_string('unique');

		$fields = array(
			'email' => $email,
			'auth_key' => $auth_key
		);

		$this->db->delete('users_pending', array('email' => $email));
		$this->db->insert('users_pending', $fields);
		
		$this->sendConfirmationEmail($email, $auth_key);
	}
	
	public function sendConfirmationEmail($email, $auth_key)
	{
		$this->load->library('email');
		
		$this->email->from('admin@fastfude.org', 'Fastfude');
		$this->email->to($email); 
		
		$this->email->subject('Confirm your email address');
		$this->email->message('Hi there, this is a confirmation email for your account on '.base_url().'
Please confirm your email address is valid by clicking the link below:

{unwrap}'.site_url('user/confirm/'.$auth_key).'{/unwrap}

If you didn\'t try to register or change your address, you can safely ignore this email.

all the best,

Fastfude');	
		
		$this->email->send();
	}

	public function sendForgotPasswordEmail($email, $auth_key)
	{
		$this->load->library('email');

		$this->email->from('admin@fastfude.org', 'Fastfude');
		$this->email->to($email); 

		$this->email->subject('Reset your password');
		$this->email->message('Hi there, this email was sent in response to a forgot password claim for your username at '.base_url().'
Please confirm you\'d like to reset your password by clicking the link below:

{unwrap}'.site_url('user/recover/'.$auth_key).'{/unwrap}

If you didn\'t ask for this, you can safely ignore this email.

all the best,

Fastfude');	
	
		$this->email->send();
	}
	
	public function getPendingEmail($auth_key)
	{
		$this->db->select('email');
		$query = $this->db->get_where('users_pending', array('auth_key' => $auth_key));
		
		if ($query->num_rows > 0) 
		{
			$row = $query->row();
			return $row->email;
		}
	}

	public function createUser($username, $password, $email)
	{
		$fields = array(
			'username' => $username, 
			'password' => $this->encryptPassword($password), 
			'email' => $email
		);

		$this->db->delete('users_pending', array('email' => $email));
		$this->db->insert('users', $fields);

		return $this->db->insert_id();
	}
	
	public function muteUser($user_id, $muted_user_id)
	{
		$data = array('user_id' => $user_id, 'muted_user_id' => $muted_user_id);

		$insert_query = $this->db->insert_string('users_muted', $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$this->db->query($insert_query);
	}
	
	public function unmuteUser($user_id, $muted_user_id)
	{
		$this->db->delete('users_muted', array('user_id' => $user_id, 'muted_user_id' => $muted_user_id));
	}
	
	public function getMutedUsers($user_id)
	{
		$this->db->select('muted_user_id');
		$query = $this->db->get_where('users_muted', array('user_id' => $user_id));
		
		$muted = array();

		if ($query->num_rows > 0) 
		{
			foreach ($query->result() as $row) 
			{
				$muted[] = $row->muted_user_id;
			}
		}

		return $muted;
	}
	
	public function changeUsername($user_id, $new_name)
	{
		$this->db->where('id', $user_id);
		$this->db->update('users', array('username' => $new_name));
	}
	
	public function changeEmail($user_id, $new_email)
	{
		$this->db->where('id', $user_id);
		$this->db->update('users', array('email' => $new_email));

		$this->db->delete('users_pending', array('email' => $new_email));
	}

	public function changeNotifications($user_id, array $notifications)
	{
		$this->db->delete('users_settings', array('user_id' => $user_id, 'key' => 'notifications'));

		if (count($notifications) > 0) 
		{
			$insert = array();
			
			foreach ($notifications as $row) 
			{
				$insert[] = array('user_id' => $user_id, 'key' => 'notifications', 'value' => $row);
			}
			
			$this->db->insert_batch('users_settings', $insert);
		}
	}

	public function getUserID($username, $password)
	{
		$enc_pass = $this->encryptPassword($password);

		$this->db->select('id');
		$query = $this->db->get_where('users', array('username' => $username, 'password' => $enc_pass));
		
		if ($query->num_rows > 0) 
		{
			$row = $query->row();
			return $row->id;
		}
	}

	public function setUserSetting($user_id, $key, $value)
	{
		$this->db->delete('users_settings', array(
			'user_id' => $user_id,
			'key' => $key
		));

		if ($value != '') 
		{
			$this->db->insert('users_settings', array(
				'user_id' => $user_id,
				'key' => $key,
				'value' => $value
			));
		}
	}

	public function getUserSettings($user_id)
	{
		$query = $this->db->get_where('users_settings', array('user_id' => $user_id));
		
		if ($query->num_rows > 0) 
		{
			$settings = array();
			foreach ($query->result() as $row) 
			{
				if (isset($settings[$row->key])) 
				{
					if (is_array($settings[$row->key])) 
					{
						// already an array, so just push new value
						$settings[$row->key][] = $row->value;
					}
					else
					{
						// convert existing value to array then push new one
						$settings[$row->key] = array($settings[$row->key], $row->value);
					}
				}
				else
				{
					// single value
					$settings[$row->key] = $row->value;
				}
			}
			return $settings;
		}
	}
	
	public function deleteUserSettings($user_id, $key, $value = null)
	{
		$this->db->where('user_id', $user_id);

		if ($key != 'all') {
			$this->db->where('key', $key);
		}
		
		if ($value) {
			$this->db->where('value', $value);
		}
		
		$this->db->delete('users_settings');
	}
	
	public function eraseUserProfile($user_id)
	{
		$this->db->where('id', $user_id);
		$this->db->update('users', array(
			'username' => 'user_'.$user_id,
			'email' => 'user+'.$user_id.'@fastfude.org',
			'password' => $this->encryptPassword(random_string('unique'))
		));
	}
	
	public function getNotificationsSettings($user_id)
	{
		$query = $this->db->get_where('users_settings', array('user_id' => $user_id, 'key' => 'notifications'));

		$settings = array();

		if ($query->num_rows > 0) 
		{
			foreach ($query->result() as $row) 
			{
				$settings[] = $row->value;
			}
		}

		return $settings;
	}
	
	public function createPasswordResetKey($user_id)
	{
		$insert = array(
			'user_id' => $user_id,
			'key' => sha1(uniqid('', true))
		);

		$this->db->insert('users_forgot_pw', $insert);
	}
	
	public function isValidRecoveryKey($key)
	{
		$this->db->select('user_id');
		$query = $this->db->get_where('users_forgot_pw', array('key' => $key));
		
		if ($query->num_rows() > 0) 
		{
			$row = $query->row();
			return $row->user_id;
		}
		else
		{
			return false;
		}
	}
	
	public function resetPassword($user_id, $password)
	{
		$this->db->where('id', $user_id);
		$this->db->update('users', array('password' => $this->encryptPassword($password)));
		
		$this->db->where('user_id', $user_id);
		$this->db->delete('users_forgot_pw');
	}

	public function encryptPassword($str)
	{
		return crypt($str, $this->config->item('encryption_key'));
	}
	
	public function getCommonPasswords()
	{
		return array(
			'111111',
			'123123',
			'123456',
			'1234567',
			'12345678',
			'abc123',
			'ashley',
			'baseball',
			'dragon',
			'football',
			'iloveyou',
			'letmein',
			'master',
			'michael',
			'monkey',
			'mustang',
			'password',
			'password1',
			'password12',
			'password123',
			'qwerty',
			'shadow',
			'sunshine',
			'trustno1',
			'welcome'
		);
	}
}
