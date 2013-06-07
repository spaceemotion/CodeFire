<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Load admin controller
require_once APPPATH . "core/codefire/admin_controller.php";

class Groups extends Admin_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('group_model');
	}

	public function index()
	{
		$this->_set_default_tab('list');

		$this->_publish_user('groups/index', array(
			'groups' => $this->group_model->find_all()
		));
	}

	public function edit($id = false)
	{
		if($id === false)
		{
			show_404();
			return;
		}

		$group = $this->group_model->find_id($id);

		$this->_publish_user('groups/edit', array(
			'group' => $group,
			'keys' => $this->codefire->getAccessKeys($group->id, true)
		));
	}

	public function create()
	{
		$group_id = null;

		$this->_set_tab('create');

		if($group_id !== null)
		{
			$this->edit($group_id);
		}
		else
		{
			$this->index();
		}
	}

}

/* End of file groups.php */
/* Location: ./application/controllers/groups.php */