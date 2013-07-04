<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Load admin controller
require_once APPPATH . "core/codefire/admin_controller.php";

class Access extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('access_model');
	}


	// ------------------------------------------------------------------------
	// Page functions
	// ------------------------------------------------------------------------

	public function index()
	{
		$this->_set_default_tab('list');

		$this->_publish_tab('users', 'access/index', array(
			'keys' => $this->access_model->find_all()
		));
	}

	public function edit($key_id)
	{
		if($this->input->post('key_id') !== FALSE)
		{
			$this->_set_rules();

			if(!$this->form_validation->run())
			{
				$this->_set_notice('<h4>Could not create access key</h4>' . validation_errors(), 'error', FALSE);
			}
			else
			{
				if($this->access_model->update($this->input->post('key_id'), $this->_get_form_data()))
				{
					$this->_set_notice("Access key updated!", 'success', false);
				} 
				else
				{
					$this->_set_notice("Error updating access key!", 'error', false);
				}
			}
		}

		$this->load->model('group_model');

		$group_names = $this->group_model->find_select('id', 'title');

		$select_data = array();
		foreach($group_names as $group)
		{
			$select_data[$group->id] = $group->title;
		}

		$this->_publish_tab('users', 'access/edit', array(
			'key' => $this->access_model->find_id($key_id),
			'groups' => $this->access_model->getGroupKeys($key_id),
			'users' => $this->access_model->getUserKeys($key_id),
			'group_names' => $select_data
		));
	}

	/** Post-Data only */
	public function set()
	{
		$key_id = $this->input->post('key_id');
		$user_id = $this->input->post('id');

		$group = $this->input->post('group');
		$grant = $this->input->post('activated') !== FALSE;

		if($this->access_model->setAccess($key_id, $user_id, $group, $grant))
		{
			$this->_set_notice("Access key set to " . ($grant? 'allowed' : 'denied') . "!");
		}
		else
		{
			$this->_set_notice('Error updating access key!', 'error');
		}

		if($this->input->post('key') !== FALSE)
		{
			redirect(CodeFire::ADMINCP . 'users/access/edit/' . $key_id);
		}
		else if($group)
		{
			redirect(CodeFire::ADMINCP . 'users/groups/edit/' . $user_id);
		}
		else
		{
			redirect(CodeFire::ADMINCP . 'users/manage/edit/' . $user_id);
		}
	}

	/** Post-Data only */
	public function revoke()
	{
		$user_id = $this->input->post('user_id');
		$group = $this->input->get_post('group') !== FALSE;
		$key_id = $this->input->post('key_id');

		if($this->access_model->revokeAccess($key_id, $user_id, $group))
		{
			$this->_set_notice('Access key revoked!');
		}
		else
		{
			$this->_set_notice('Access key does not exist (or belongs to a group)!', 'error');
		}

		if($this->input->post('key') !== FALSE)
		{
			redirect(CodeFire::ADMINCP . 'users/access/edit/' . $key_id);
		} 
		else
		{
			redirect(CodeFire::ADMINCP . 'users/' . ($group ? 'groups' : 'manage') . '/edit/' . $user_id);
		}
	}

	public function create()
	{
		$key_id = null;

		$this->_set_rules();

		if($this->form_validation->run() !== FALSE)
		{
			if($key_id = $this->access_model->insert($this->_get_form_data()))
			{
				$this->_set_notice('Access key created!', 'success', FALSE);
			}
			else
			{
				$this->_set_notice('Could not create access key!', 'error', FALSE);
			}
		}
		elseif($this->input->post('submit') !== FALSE)
		{
			$this->_set_notice('<h4>Could not create access key1</h4>' . validation_errors(), 'error', FALSE);
		}

		$this->_set_tab('create');

		if($key_id !== null) $this->edit($key_id);
		else $this->index();
	}

	/** Post-Data only */
	public function add($type = 'key')
	{
		$id = $this->input->post('id');
		$key = $this->input->post('key');

		$group = $this->input->post('group') !== false;
		$grant = $this->input->post('action') == 'Grant';

		$success = false;
		$updated = false;

		if ($type == 'user')
		{
			// TODO
		}
		elseif($type == 'group')
		{
			// --- Remember ---
			// key: the group
			// id: the key-id

			$success = $this->access_model->setAccess($id, $key, $group, $grant);
			$updated = true;
		}
		else
		{
			$key_id = $this->access_model->getId($key)->row_array();

			if(isset($key_id['id']))
			{
				$success = $this->access_model->setAccess($key_id['id'], $id, $group, $grant);
				$updated = true;
			}
			else
			{
				$this->_set_notice('Access key does not exist!', 'error');
			}
		}

		// Show error message
		if($updated)
		{
			if($success) $this->_set_notice('Access key added');
			else $this->_set_notice('Could not add access key', 'error');
		}

		redirect($this->input->post('redirect'));
	}

	/** Post-Data only */
	public function delete()
	{
		$key_id = $this->input->post('key_id');
		$this->access_model->delete($key_id);
		
		$this->_set_notice('Access key removed', FALSE);

		$this->index();
	}


	// ------------------------------------------------------------------------
	// Protected / Private functions
	// ------------------------------------------------------------------------

	protected function _set_rules() {
		$this->form_validation->set_rules('key', 'Identifier', 'required|max_length[24]');
		$this->form_validation->set_rules('name', 'Key name', 'required|max_length[32]');
		$this->form_validation->set_rules('description', 'Description', 'required|max_length[64]');
	}

	protected function _get_form_data() {
		return array(
			'key' => set_value('key'),
			'name' => set_value('name'),
			'description' => set_value('description')
		);
	}

}

/* End of file privileges.php */
/* Location: ./application/controllers/privileges.php */