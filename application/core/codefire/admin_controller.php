<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends Application {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('template');
		$this->template->set_template('cf_admin');

		$this->auth->restrict(1);

		$notice = $this->session->flashdata('notice');
		if($notice !== false) $this->_validate_notice($notice);
	}

	protected function _publish($name, $data = null)
	{
		$this->template->content = $this->auth->view($name, $data);
		$this->template->publish();
	}

	protected function _publish_tab($group, $name, $data = null)
	{
		$this->_publish($group . '/layout', array(
			'active' => $name,
			'content' => $this->auth->view($group . '/' . $name, $data)
		));
	}

	protected function _set_notice($text, $type = 'success', $use_flash = true) {
		$data = array('type' => $type, 'text' => $text);
		
		if($use_flash) {
			$this->session->set_flashdata('notice', $data);

		} else {
			$this->_validate_notice($data);
		}
	}

	protected function _set_tab($tab) {
		$this->template->tab = $tab;
	}

	protected function _set_default_tab($tab) {
		if($this->template->tab->content() == NULL) $this->template->tab = $tab;
	}

	private function _validate_notice($data) {
		$this->template->notice = $this->auth->view('notice', $data);

		$this->session->set_flashdata('notice', false);
	}

}

/* End of file admin_controller.php */
/* Location: ./application/controllers/admin_controller.php */
