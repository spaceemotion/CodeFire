<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends MY_Model {

	public function __construct()
	{
		parent::__construct(CodeFire::TABLE_USERS);
	}

	public function delete($id)
	{
		parent::delete($id);

		if($id != NULL)
		{
			$this->db->where('id', $id);
			$this->db->where('group', FALSE);
			$this->db->delete(CodeFire::TABLE_ACCESS);
		}
	}

}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */