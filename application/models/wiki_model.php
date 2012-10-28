<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Wiki_model extends CI_Model
{
	public function getRecentEdits()
	{
		$this->db->select('p.title, p.stub, h.id as edit_id, UNIX_TIMESTAMP(h.created) as created, h.user_id, u.username, md5(u.email) as gravatar_id');
		
		$this->db->join('wiki_history h', 'p.id = h.page_id', 'left outer');
		$this->db->join('users u', 'u.id = h.user_id', 'left outer');
		
		$this->db->order_by('h.created', 'desc');
		$this->db->limit(100);

		$query = $this->db->get('wiki_pages p');
		
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return NULL;
	}
	
	public function getCurrentPage($stub)
	{
		$this->db->select('p.*, h.*, u.username, md5(u.email) as gravatar_id');

		$this->db->where('p.stub', $stub);

		$this->db->join('wiki_history h', 'p.id = h.page_id', 'left outer');
		$this->db->join('users u', 'u.id = h.user_id', 'left outer');

		$this->db->order_by('h.created', 'desc');
		$this->db->limit(1);

		$query = $this->db->get('wiki_pages p');
		
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		
		return NULL;
	}
	
	public function getPageEdit($edit_id)
	{
		$this->db->select('p.*, h.*, u.username, md5(u.email) as gravatar_id');
	
		$this->db->where('h.id', $edit_id);
	
		$this->db->join('wiki_history h', 'p.id = h.page_id', 'left outer');
		$this->db->join('users u', 'u.id = h.user_id', 'left outer');
	
		$query = $this->db->get('wiki_pages p');
		
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		
		return NULL;
	}
	
	public function getPageHistory($page_id)
	{
		$this->db->select('h.id, UNIX_TIMESTAMP(h.created) as created, h.user_id, u.username, md5(u.email) as gravatar_id');

		$this->db->where('h.page_id', $page_id);

		$this->db->join('users u', 'u.id = h.user_id', 'left outer');

		$this->db->order_by('h.created', 'desc');

		$query = $this->db->get('wiki_history h');

		if ($query->num_rows() > 0) {
			return $query->result();
		}

		return NULL;
	}
}
