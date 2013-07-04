<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Load admin controller
require_once APPPATH . "core/codefire/admin_controller.php";

class Manage extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('user_model');
	}


	// ------------------------------------------------------------------------
	// Page functions
	// ------------------------------------------------------------------------

	public function index()
	{
		$this->load->model('custom_fields_model', 'custom');

		$this->_publish_user('list', array(
			'users' => $this->user_model->find_select('id', 'username', 'email', 'activated', 'banned')
		));
	}

	public function edit($user_id = false)
	{
		// Show index page if no user id was given
		if($user_id === false)
		{
			$this->_set_notice('No user ID given!', 'info', FALSE);
			$this->index();

			return;
		}

		// Prepare custom fields
		$password = $this->input->get_post('password');
		$custom_fields = $this->_set_register_rules(TRUE, $password != '');
		$this->form_validation->set_rules('group', 'User group', 'required');

		// Load models
		$this->load->model('custom_data_model', 'data');

		// Check for form submission
		if($this->form_validation->run() !== FALSE)
		{
			// Default / General fields
			$update = array(
				'username' => set_value('username'),
				'email' => set_value('email'),
				'group_id' => set_value('group'),
				'activated' => $this->input->get_post('activated') !== FALSE,
				'banned' => $this->input->get_post('banned') !== FALSE,
				'ban_reason' => $this->input->get_post('ban_reason')
			);

			if($password != '')
			{
				$update['password'] = $this->phpass->hash($password);
			}

			if($this->user_model->update($user_id, $update))
			{
				$this->_set_notice('User data updated!', 'success', FALSE);
			}

			// TODO custom fields
		}
		elseif($this->input->post('submit') !== FALSE)
		{
			// Display form error message
			$this->_set_notice('<h4>Could not edit user!</h4>' . validation_errors(), 'error', FALSE);
		}
		
		// Fetch user
		$user = $this->user_model->find_id($user_id);

		// Show index page and notice if user does not exist
		if($user == null)
		{
			$this->_set_notice('This user does not exist!', 'info', FALSE);
			$this->index();

			return;
		}

		// Load group model
		$this->load->model('group_model');

		// Display edit page
		$this->_publish_user('edit', array(
			'user' => $user,
			'keys' => $this->codefire->getUserAccess($user->id, $user->group_id),
			'fields' => $this->fields->find_all(),
			'data' => $this->data->find_user($user->id),
			'groups' => $this->group_model->group_select()
		));
	}

	public function create()
	{
		// Prepare custom fields
		$custom_fields = $this->_set_register_rules();
		$this->form_validation->set_rules('group', 'User group', 'required');

		// Check for form submission
		if($this->form_validation->run() !== FALSE)
		{
			// Default / General fields
			$username = set_value('username');
			$password = $this->phpass->hash(set_value('password'));
			$email = set_value('email');

			// Create user
			$user_id = $this->authentication->register($username, $password, $email, set_value('group'));

			if($user_id !== FALSE)
			{
				// Insert custom information
				$this->load->model('custom_data_model', 'data');

				if($this->data->insert_from_post($user_id, $custom_fields))
				{
					// If user was created, show edit page
					$this->_set_notice('User created!', 'success', FALSE);

					redirect(CodeFire::ADMINCP . 'users/manage/edit/' . $user_id);
					return;
				}
			}
			else
			{
				// Display db error message
				$this->_set_notice('Could not create user (Internal database error)!', 'error', FALSE);
			}
		}
		elseif($this->input->post('submit') !== FALSE)
		{
			// Display form error message
			$this->_set_notice('<h4>Could not create user!</h4>' . validation_errors(), 'error', FALSE);
		}

		// Load group model
		$this->load->model('group_model');

		// Show create page
		$this->_publish_user('create', $this->auth->view('forms/user/create', array(
			'url' => $this->uri->uri_string(),
			'submit' => 'Create user',

			'admin' => true,
			'create' => true,

			'username' => set_value('username'),
			'email' => set_value('email'),

			'fields' => $custom_fields,

			'groups' => $this->group_model->group_select(),
			'group' => set_value('group', CodeFire::getSetting('user', 'defaultGroup'))
		)), true);
	}

	public function delete()
	{
		$user_id = $this->input->get_post('user_id');

		if($user_id !== FALSE)
		{
			$this->user_model->delete($user_id);

			$this->_set_notice('User deleted from system', 'success', FALSE);
		}

		$this->index();
	}


	// ------------------------------------------------------------------------
	// Protected / Private functions
	// ------------------------------------------------------------------------

	protected function _publish_user($file, $data = NULL, $iscontent = FALSE)
	{
		$this->_set_tab($file);

		parent::_publish_tab('users', 'manage/index', array(
			'content' => $iscontent ? $data : $this->auth->view('users/manage/' . $file, $data)
		));
	}

}

/* End of file manage.php */
/* Location: ./application/controllers/manage.php */