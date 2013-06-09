<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets
{
	protected static $config;

	public function __construct($config)
	{
		self::$config = $config;

		log_message('debug', "Asset Library Loaded");
	}

	public static function add_css($filename, $module = null)
	{
		$CI =& get_instance();

		$CI->template->stylesheet->add(self::get_css($filename, $module));
	}

	public static function get_css($filename, $module = null)
	{
		return self::_get($filename, self::$config['css_dir'], $module);
	}

	public static function add_script($filename, $module = null)
	{
		$CI =& get_instance();

		if($module === FALSE)
		{
			$CI->template->javascript->add($filename, true);
		}
		else
		{
			$CI->template->javascript->add(self::get_script($filename, $module));
		}
	}

	public static function get_script($filename, $module = null)
	{
		return self::_get($filename, self::$config['scripts_dir'], $module);
	}

	public static function get_image($filename, $module = null)
	{
		return self::_get($filename, self::$config['images_dir'], $module);
	}

	protected static function _get($filename, $folder, $module = null)
	{
		$url = base_url();

		if($module !== null)
		{
			$CI =& get_instance();

			if(is_a($module, 'Widget'))
			{
				$url .= $CI->codefire->config('widget_path') . $CI->template->get_template() . '/';
			}
			elseif(is_a($module, 'Template'))
			{
				$url .= $CI->codefire->config('template_path') . $CI->template->get_template() . '/';
			}
			elseif(is_a($module, 'Module'))
			{
				$url .= $CI->codefire->config('module_path') . $module . '/';
			}
		}

		return $url . self::$config['assets_dir'] . '/' . $folder . '/' . $filename;
	}

}