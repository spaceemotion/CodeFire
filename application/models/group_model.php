<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_Model extends My_Model {

	public function __construct()
	{
		parent::__construct('groups');
	}

	public function group_select()
	{
		$groups = $this->find_select('id', 'title');
		$array = array();

		$guest = CodeFire::getSetting('user', 'guestGroup');

		foreach($groups as $group)
		{
			if($group->id == $guest) continue;
			
			$array[$group->id] = $group->title;
		}

		return $array;
	}

}

/* End of file group_model.php */
/* Location: ./application/models/group_model.php */