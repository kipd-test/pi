<?php

class User extends CI_Model {
	
	public function __construct()
	{
		$this->load->database();
	}

	public function getUsers($id = FALSE)
	{
		if ($id == FALSE) {
			$query = $this->db->get('users');
			return $query->result();
		} else {
			$query = $this->db->get_where('users', array('ID' => $id));
			return $query->row_array();
		}
	}
	
	public function getUserLogin($user_name, $password)
	{
		$query = $this->db->get_where('users', array('UserName' => $user_name, 'Password' =>$password));
		return $query->row_array();
	}
	
	public function createUser($data)
	{
		$this->db->insert('users', $data);
	}

	public function updateUser($data, $id)
	{
		$this->db->update('users', $data, 'ID = ' . $id);
	}
	
}
