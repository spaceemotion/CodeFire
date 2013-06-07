<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Load admin controller
require_once APPPATH . "core/codefire/admin_controller.php";

class Fields extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('custom_fields_model', 'fields');
	}

	public function index()
	{
		$this->_set_default_tab('list');

		$this->_publish_user('fields/index', array(
			'fields' => $this->fields->find_all()
		));
	}

}

/* End of file fields.php */
/* Location: ./application/controllers/fields.php */