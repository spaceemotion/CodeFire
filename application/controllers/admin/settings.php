<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Load admin controller
require_once APPPATH . "core/codefire/admin_controller.php";

class Settings extends Admin_Controller {

	public function index()
	{
		$this->_publish('settings');
	}

}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */