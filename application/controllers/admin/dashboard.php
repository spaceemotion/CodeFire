<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Load admin controller
require_once APPPATH . "core/codefire/admin_controller.php";

class Dashboard extends Admin_Controller {

	public function index()
	{
		$this->_publish('dashboard');
	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */