<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('single_button_form'))
{
	function single_button_form($url, $text, $hidden = array())
	{
		// Open form
		$out = form_open($url, array('class' => 'no-margin'), $hidden);

		// Add button
		if(is_array($text)) {
			$out .= form_submit(array(
				'value' => $text['value'],
				'class' => 'btn ' . $text['class']
			));

		} else {
			$out .= form_submit(array(
				'value' => $text,
				'class' => 'btn'
			));
		}

		// Close form
		$out .= form_close();

		return $out;
	}
}

if(!function_exists('single_checkbox_form'))
{
	function single_checkbox_form($url, $checked, $disabled, $hidden)
	{
		$out = form_open($url, 'class="no-margin"', $hidden);
		
		$cbopt = array(
			'name' => 'activated',
			'checked' => $checked,
			'onChange' => 'this.form.submit()'
		);

		if($disabled) $cbopt['disabled'] = 'disabled';

		$out .= form_checkbox($cbopt);

		return $out . form_close();
	}
}

if(!function_exists('_checkActive'))
{
	function _checkActive($key, $partial = 'active', $echo = 'class="active"')
	{
		$CI =& get_instance();
		$tmpl = $CI->template->{$partial};

		echo $tmpl !== FALSE && $tmpl == $key ? $echo : '';
	}
}

/* End of file codefire.php */
/* Location: ./application/controllers/codefire.php */