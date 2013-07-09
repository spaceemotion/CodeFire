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

		// Captcha type
		$this->type = $this->ci->codefire->getSetting('user', 'captcha');

		if($this->need_captcha())
		{
			// Load helper
			$this->ci->load->helper('captcha');

			// Initalize captcha library
			$this->initalize();
		}
	}

	public function initalize()
	{
		// Delete old captchas
		$this->ci->db->delete($this->table, "time < " . (time() - $this->expiration));
	}

	public function setup_form()
	{
		if($this->need_captcha())
		{
			$this->ci->form_validation->set_rules('captcha', 'Captcha', 'trim|required|max_length[20]|xss_clean|callback_check_captcha');
		}
	}

	public function create_captcha()
	{
		if(!$this->need_captcha())
		{
			return NULL;
		}

		// Create image
		$this->captcha = create_captcha(array(
			'img_path' => './captcha/',
			'img_url' => base_url('captcha'). '/',
			'expiration' => $this->expiration
		));

		// Add database entry
		$this->ci->db->insert($this->table, array(
			'time' => $this->captcha['time'],
			'ip_address' => $this->ci->input->ip_address(),
			'secret' => $this->captcha['word']
		));

		return $this->captcha;
	}

	public function get_captcha()
	{
		if($this->need_captcha())
		{
			if(!$this->captcha)
			{
				$this->create_captcha();
			}

			return $this->captcha['image'];
		}

		return NULL;
	}

	public function check_captcha($input)
	{
		if($this->need_captcha())
		{
			$this->ci->db->select_sum('captcha_id', 'count');
			$this->ci->db->from($this->table);
			$this->ci->db->where('secret', $input);
			$this->ci->db->where('ip_address', $this->ci->input->ip_address());
			$this->ci->db->where('time > ' . $this->expiration);

			$result = $this->ci->db->get();

			if($result->row()->count == 0)
			{
				$this->ci->form_validation->set_message('check_captcha', 'Invalid captcha entered');
				return FALSE;
			}
		}
		
		return TRUE;
	}

	public function need_captcha()
	{
		return $this->type != 'none';
	}

}

/* End of file captcha.php */
/* Location: ./application/libraries/captcha.php */
