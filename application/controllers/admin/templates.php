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
		$this->_publish('templates/list', array(
			'templates' => $this->template->get_templates()
		));
	}

	public function view($name = '')
	{
		$info = $this->template->get_template_information(rawurldecode($name));
		
		$this->_publish('templates/view', $info);
	}

}

/* End of file templates.php */
/* Location: ./application/controllers/templates.php */