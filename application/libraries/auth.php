<?php

/**
* Authentication Library
*
* @package Authentication
* @category Libraries
* @author Adam Griffiths
* @link http://adamgriffiths.co.uk
* @version 2.0.3
* @copyright Adam Griffiths 2011
*
* Auth provides a powerful, lightweight and simple interface for user authentication .
*/

// ob_start();

class Auth
{
	var $CI; // The CI object
	var $config; // The config items
	
	
	/**
	* @author Adam Griffiths
	* @param array
	*
	* The constructor public function loads the libraries dependancies and creates the 
	* login attempts cookie if it does not already exist.
	*/
	public function __construct($config)
	{
		log_message('debug', 'Auth Library Loaded');

		$this->config = $config;

		$this->CI =& get_instance();
		$this->CI->lang->load('auth', 'english');
		
		if($this->logged_in() == FALSE)
		{
			if(!array_key_exists('login_attempts', $_COOKIE))
			{
				setcookie("login_attempts", 0, time()+900, '/');
			}
		}
		
	}
	
	
	/** 
	* Restricts access to a page
	*
	* Takes a user level (e.g. admin, user etc) and restricts access to that user and above.
	* Example, users can access a profile page, but so can admins (who are above users)
	*
	* @access public
	* @param string
	* @return bool
	*/
	public function restrict($group_id = NULL, $single = FALSE)
	{
		if($group_id === NULL)
		{
			if($this->logged_in() == TRUE)
			{
				return TRUE;
			}
			else
			{
				show_error($this->CI->lang->line('insufficient_privs'));
			}
		}
		elseif($this->logged_in() == TRUE)
		{
			$user_level = $this->CI->session->userdata('group_id');
			
			if($user_level > $group_id OR $single == TRUE && $user_level !== $group_id)
			{
				show_error($this->CI->lang->line('insufficient_privs'));
			}
			
			return TRUE;
		}
		else
		{
			redirect(CodeFire::getSetting('auth' , 'incorrect_login'), 'refresh');
		}
	} // public function restrict()
	
	
	/**
	* @author Adam Griffiths
	* @return bool
	*
	* Checks the session data as to whether or not a user is logged in.
	*/
	public function logged_in()
	{
		return ($this->CI->session->userdata('logged_in') === TRUE);
	}
	
	
	/**
	* @author Adam Griffiths
	* @param string
	* @param string
	* @return string / bool
	*
	* Takes a username & optional username type (email/username) and returns the user data
	*/
	public function get_user($username, $field_type = 'username')
	{
		$user = $this->CI->authentication->login_check($username, $field_type);

		return $user;
	}
	
	
	/**
	* @author Adam Griffiths
	* @param string
	* @param string
	* @param string
	* @return bool
	*
	* Creates a new user account
	*/
	public function register($username, $password, $email)
	{
		return $this->CI->authentication->register($username, $password, $email);
	}
	
	
	/**
	* @author Adam Griffiths
	* @param array
	*
	* Takes the user array, adds the logged_in portion and sets the session data from that.
	*/
	public function login_user($user)
	{
		$user['logged_in'] = TRUE;
		
		$this->CI->session->set_userdata($user);
	}
	
	
	/** 
	* Destroys the user session.
	*
	* @access public
	*/
	public function logout()
	{
		$this->CI->session->sess_destroy();
		redirect(CodeFire::getSetting('auth', 'logout'));
	}
	
	
	/** 
	* Generate a new token/identifier from random.org
	*
	* @author Adam Griffiths
	* @access private
	* @param string
	*/
	private  function _generate()
	{
		$username = $this->CI->session->userdata('username');
	
		// No love either way, generate a random string ourselves
		$length = 20;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$token = "";    
		
		for ($i = 0; $i < $length; $i++)
		{
			$token .= $characters[mt_rand(0, strlen($characters)-1)];
		}
	
		$identifier = $username . $token;
		$identifier = $this->_salt($identifier);

		$this->CI->db->query("UPDATE `$this->user_table` SET `identifier` = '$identifier', `token` = '$token' WHERE `username` = '$username'");

		setcookie("logged_in", $identifier, time()+3600, '/');
	  
	}
	
	
	/** 
	* Verify that a user has a cookie, if not generate one. If the cookie doesn't match the database, log the user out and show them an error.
	*
	* @access private
	* @param string
	*/
	private function _verify_cookie()
	{
		if((array_key_exists('login_attempts', $_COOKIE)) && ($_COOKIE['login_attempts'] <= 5))
		{
			$username = $this->CI->session->userdata('username');
			$userdata = $this->CI->db->query("SELECT * FROM `$this->user_table` WHERE `username` = '$username'");
			
			$result = $userdata->row();

			$identifier = $result->username . $result->token;
			$identifier = $this->_salt($identifier);
			
			if($identifier !== $_COOKIE['logged_in'])
			{
				$this->CI->session->sess_destroy();
				
				show_error($this->CI->lang->line('logout_perms_error'));
			}
		}
		else
		{
			$this->_generate();
		}
	}
	
	
	/** 
	* Load an auth specific view
	*
	* @access private
	* @param string
	*/
	public function view($page, $params = NULL)
	{
		$data = array('page' => explode('/', $page));
		if($params !== NULL) $data = array_merge($params, $data);

		return $this->CI->load->view($this->config['auth_views_root'] . $page, $data, TRUE);
	}
	
}

/* End of file: AG_Auth.php */
/* Location: application/libraries/AG_Auth.php */