<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CodeFire {
	// Constants
	const TABLE_ACCESS = 'access';
	const TABLE_ACCESS_KEYS = 'access_keys';

	const TABLE_GROUPS = 'groups';
	const TABLE_USERS = 'users';

	const TABLE_CUSTOM_FIELDS = 'user_fields';
	const TABLE_CUSTOM_DATA = 'user_data';

	const TABLE_SETTINGS = 'settings';

	const ADMINCP = 'admin/';

	// Class statics
	protected static $settings;

	// Object variables
	protected $CI;

	public function __construct($config = array())
	{
		$this->CI =& get_instance();
		$this->CI->load->database();

		// Load configuration
		$this->_config = $config;

		// Load settings table information
		$data = $this->CI->db->get(CodeFire::TABLE_SETTINGS)->result();

		foreach($data as $entry) {
			self::$settings[$entry->key] = $entry->value;
		}
	}

	public function getUserAccess($user_id, $group_id)
	{
		return array_merge($this->getAccessKeys($group_id, true), $this->getAccessKeys($user_id));
	}

	public function getGroupAccess($group_id)
	{
		// Group rank clause
		$this->CI->db->select('rank AS group_rank')->where('id', $group_id);
		$group_rank = $this->CI->db->get_compiled_select(CodeFire::TABLE_GROUPS);

		// Get groups below or equal to current group rank
		$this->CI->db->select('id AS group_id')->where("rank >= ($group_rank)", NULL, FALSE);
		$groups = $this->CI->db->get_compiled_select(CodeFire::TABLE_GROUPS);

		// Get access keys
		$this->CI->db->select(CodeFire::TABLE_ACCESS . '.id, key_id, key, allow');
		$this->CI->db->from(CodeFire::TABLE_ACCESS);

		$this->CI->db->join(CodeFire::TABLE_ACCESS_KEYS, CodeFire::TABLE_ACCESS_KEYS . '.id=key_id');

		$this->CI->db->where(CodeFire::TABLE_ACCESS . ".id IN ($groups)", NULL, FALSE);
		$this->CI->db->where('group = 1');
		
		return $this->CI->db->get()->result();
	}

	public function getAccessKeys($id, $isGroup = false)
	{
		$query = $this->CI->db->select('group, key_id, allow, key')->from(CodeFire::TABLE_ACCESS);

		$query->join(CodeFire::TABLE_ACCESS_KEYS, 'key_id = ' . CodeFire::TABLE_ACCESS_KEYS . '.id');

		if($isGroup) {
			// $query->order_by(CodeFire::TABLE_ACCESS . '.id', 'desc');
			
		} else {
			$query->where(CodeFire::TABLE_ACCESS . '.id', $id);
		}

		$query->where('group', $isGroup);
		$query->order_by('key', 'asc');
		
		return $query->get()->result();
	}

	public function setSetting($key, $value)
	{
		$this->CI->db->update(CodeFire::TABLE_SETTINGS, array(
			'key' => $key,
			'value' => $value
		));
	}

	public static function getSetting()
	{
		$key = implode('.', func_get_args());
		return isset(self::$settings[$key]) ? self::$settings[$key] : null;
	}

	public function config($key) {
		return $this->_config[$key];
	}

}

/* End of file CodeFire.php */
/* Location: ./application/controllers/CodeFire.php */