<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom_fields_model extends MY_Model {

	public function __construct()
	{
		parent::__construct(CodeFire::TABLE_CUSTOM_FIELDS);
	}

}

/* End of file custom_fields_model.php */
/* Location: ./application/models/custom_fields_model.php */