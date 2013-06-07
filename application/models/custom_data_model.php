<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom_data_model extends MY_Model {

	public function __construct()
	{
		parent::__construct(CodeFire::TABLE_CUSTOM_DATA);		
	}

	public function find_user($user_id)
	{
		$this->db->where('user_id', $user_id);

		return $this->db->get($this->table)->result();
	}

	public function insert_from_post($user_id, $fields)
	{
		$success = TRUE;

		foreach($fields as $field)
		{
			$content = set_value($field->key);
			if(!$field->required && $content != $field->default) continue;

			$id = $this->insert(array(
				'id' => $field->id,
				'user_id' => $user_id,
				'data' => $content
			));

			$success = $id > 0;
		}

		return $success;
	}

}

/* End of file custom_data_model.php */
/* Location: ./application/models/custom_data_model.php */