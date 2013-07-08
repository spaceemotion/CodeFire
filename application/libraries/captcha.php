<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha
{
	protected $ci;
	protected $captcha;

	protected $expiration = 1200;
	protected $table = 'captchas';

	public function __construct()
	{
		$this->ci =& get_instance();

		// Load helper
		$this->load->helper('captcha');

		// Initalize captcha library
		$this->initalize();
	}

	public function initalize()
	{
		// Delete old captchas
		$this->ci->db->delete($this->table, "time < " . (time() - $this->expiration$expiration));
	}

	public function setup_form()
	{
		$this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|max_length[20]|xss_clean');
	}

	public function create_captcha()
	{
		// Create image
		$this->captcha = create_captcha(array(
			'img_path' => './captcha/',
			'img_url' => base_url('captcha/'),
			'expiration' => $this->expiration
		));

		// Add database entry
		$this->ci->insert($this->table, array(
			'time' => $this->captcha['time'],
			'ip_address' => $this->input->ip_address(),
			'secret' => $this->captcha['word']
		));

		return $this->captcha;
	}

	public function get_image()
	{
		if(!$this->captcha)
		{
			$this->create_captcha();
		}

		return $this->captcha['image'];
	}

	public function check_captcha()
	{
		$sql = "SELECT COUNT(*) AS count FROM " . $this->table . " WHERE secret = ? AND ip_address = ? AND time > ?";
		$query = $this->ci->db->query($sql, array(
			$this->input->post('captcha'),
			$this->input->ip_address(),
			$this->expiration
		));

		return $query->row()->count() > 0;
	}

}

/* End of file captcha.php */
/* Location: ./application/libraries/captcha.php */
