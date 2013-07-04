<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Load admin controller
require_once APPPATH . "core/codefire/admin_controller.php";

class Templates extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->_publish('templates/list');
	}

}

/* End of file templates.php */
/* Location: ./application/controllers/templates.php */