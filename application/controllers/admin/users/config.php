<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Load admin controller
require_once APPPATH . "core/codefire/admin_controller.php";

class Config extends Admin_Controller {

	public function index()
	{
		$this->_publish_tab('users', 'config', array(
			'captcha_type' => $this->codefire->getSetting('user', 'captcha')
		));
	}

}

/* End of file config.php */
/* Location: ./application/controllers/config.php */