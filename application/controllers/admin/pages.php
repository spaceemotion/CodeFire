<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Load admin controller
require_once APPPATH . "core/codefire/admin_controller.php";

class Pages extends Admin_Controller {

	public function index()
	{
		$this->_publish('pages');
	}

}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */