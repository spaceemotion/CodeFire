<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Access_Model extends MY_Model {

	public function __construct()
	{
		parent::__construct(CodeFire::TABLE_ACCESS_KEYS);
	}

	public function setAccess($key_id, $user_id, $isGroup = false, $grant = true)
	{
		$query = $this->db->insert_string(CodeFire::TABLE_ACCESS, array(
			'id' => $user_id,
			'key_id' => $key_id,
			'allow' => $grant,
			'group' => $isGroup
		));

		return $this->db->simple_query($query . " ON DUPLICATE KEY UPDATE allow = " . ($grant ? '1' : '0'));
	}

	public function revokeAccess($key_id, $user_id, $isGroup = false)
	{
		$this->db->where('key_id', $key_id);
		$this->db->where('id', $user_id);
		$this->db->where('group', $isGroup);

		return $this->db->delete(CodeFire::TABLE_ACCESS);
	}

	public function getGroupKeys($key_id)
	{
		$this->db->select('title, allow, ' . CodeFire::TABLE_GROUPS . '.id');

		$this->db->join(CodeFire::TABLE_GROUPS, CodeFire::TABLE_GROUPS . '.id = ' . CodeFire::TABLE_ACCESS . '.id');

		$this->db->where('key_id', $key_id);
		$this->db->where('group', 1);

		return $this->db->get(CodeFire::TABLE_ACCESS)->result();
	}

	public function getUserKeys($key_id)
	{
		$this->db->select('username, allow, ' . CodeFire::TABLE_USERS . '.id');

		$this->db->join(CodeFire::TABLE_USERS, CodeFire::TABLE_USERS . '.id = ' . CodeFire::TABLE_ACCESS . '.id');

		$this->db->where('key_id', $key_id);
		$this->db->where('group', 0);

		return $this->db->get(CodeFire::TABLE_ACCESS)->result();
	}

	public function getID($key) {
		return $this->db->select('id')->where('key', $key)->get(CodeFire::TABLE_ACCESS_KEYS);
	}

}

/* End of file access_model.php */
/* Location: ./application/models/access_model.php */
