<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Application extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		log_message('debug', 'Application Loaded');

		// $this->output->enable_profiler(true);
	}

	public function login($redirect = NULL)
	{
		if($redirect === NULL)
		{
			$redirect = CodeFire::getSetting('auth', 'login');
		}

		$this->form_validation->set_rules('username', 'Username / E-Mail', 'required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		
		if($this->form_validation->run() == FALSE)
		{
			echo $this->auth->view('login');
		}
		else
		{
			$username = set_value('username');
			$user_data = $this->auth->get_user($username, valid_email($username) ? 'email' : 'username');
			
			if(isset($user_data['password']) AND $this->phpass->check(set_value('password'), $user_data['password']))
			{
				if($user_data["banned"])
				{
					$this->session->sess_destroy();

					echo $this->auth->view('message', array(
						'message' => 'This user has been banned for the following reason:<p>' . $user_data["ban_reason"] . '</p>'
					));
				}
				else
				{
					unset($user_data['password']);

					$this->auth->login_user($user_data);
					
					redirect($redirect);
				}
			}
			else
			{
				$data['message'] = "The username and password did not match.";
				echo $this->auth->view('message', $data);
			}
		}
	}

	public function logout()
	{
		$this->auth->logout();
	}

	public function field_exists($value)
	{
		$field_name  = (valid_email($value)  ? 'email' : 'username');
		
		$user = $this->auth->get_user($value, $field_name);
		
		if(array_key_exists('id', $user))
		{
			$this->form_validation->set_message('field_exists', 'The ' . $field_name . ' provided already exists, please use another.');
			
			return FALSE;
		}
		
		return TRUE;
	}
	
	public function register()
	{
		$custom_fields = $this->_set_register_rules();
		$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'required|matches[password]');

		if($this->form_validation->run() == FALSE)
		{
			echo $this->auth->view('register', array(
				'fields' => $custom_fields
			));
		}
		else
		{
			$username = set_value('username');
			$password = $this->phpass->hash(set_value('password'));
			
			$email = set_value('email');

			if($this->auth->register($username, $password, $email) !== FALSE)
			{
				$data['message'] = "The user account has now been created.";
				echo $this->auth->view('message', $data);
			}
			else
			{
				$data['message'] = "Error creating user account.";
				echo $this->auth->view('message', $data);
			}
		}
	}

	protected function _set_register_rules($update = false, $use_pass = true) {
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]|max_length[24]|' . ($update ? '' : 'callback_field_exists'));
		$this->form_validation->set_rules('email', 'Email Address', 'required|min_length[6]|max_length[32]|valid_email|' . ($update ? '' : 'callback_field_exists'));

		if($use_pass) $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

		$this->load->model('custom_fields_model', 'fields');
		$custom_fields = $this->fields->find_all();

		foreach($custom_fields as $field)
		{
			$this->form_validation->set_rules($field->key, $field->name, 'trim|' . ($field->required ? 'required|' : '') . 'max_length[' . $field->length . ']');
		}

		return $custom_fields;
	}

}

/* End of file MY_Controller.php */
/* Location: ./application/controllers/MY_Controller.php */
