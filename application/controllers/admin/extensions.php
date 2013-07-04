<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Load admin controller
require_once APPPATH . "core/codefire/admin_controller.php";

class Extensions extends Admin_Controller {

	public function install()
	{
		$this->_publish_tab('extensions', 'install');
	}

}

/* End of file extensions.php */
/* Location: ./application/controllers/extensions.php */