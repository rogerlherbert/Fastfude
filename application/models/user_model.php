<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class User_model extends CI_Model
{

	public function getUser($id)
	{
		$this->db->select('id, username, MD5(email) as gravatar_id, UNIX_TIMESTAMP(created) as created');
		$query = $this->db->get_where('users', array('id' => $id));

		if ($query->num_rows > 0) 
		{
			return $query->row();
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
		
		$this->sendRegistrationEmail($email, $auth_key);
	}
	
	public function sendRegistrationEmail($email, $auth_key)
	{
		$this->load->library('email');
		
		$this->email->from('admin@fastfude.org', 'Fastfude');
		$this->email->to($email); 
		
		$this->email->subject('Confirm Your Registration');
		$this->email->message('Hi there, this is a confirmation email for your registration to '.base_url().'
Please confirm you\'d like to register by clicking the link below:

{unwrap}'.site_url('user/confirm/'.$auth_key).'{/unwrap}

If you didn\'t try to register, you can safely ignore this email.

all the best,

Fastfude');	
		
		$this->email->send();
	}

	public function sendForgotPasswordEmail($email, $auth_key)
	{
		$this->load->library('email');

		$this->email->from('admin@fastfude.org', 'Fastfude');
		$this->email->to($email); 

		$this->email->subject('Confirm Your Registration');
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

	public function createUser(array $input)
	{
		$fields = array(
			'username' => $input['username'], 
			'password' => $this->encryptPassword($input['password']), 
			'email' => $input['email']
		);

		$this->db->delete('users_pending', array('email' => $input['email']));
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
		
		if ($query->num_rows > 0) 
		{
			$column = array();

			foreach ($query->result() as $row) 
			{
				$column[] = $row->muted_user_id;
			}

			return $column;
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
}
