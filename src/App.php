<?php
/**
 * MVC App
 */
namespace WebSupportDK\PHPMvcFramework;

class App
{

	// object instance 
	private static
		$_instance = null;
	public
		$data;

	// singleton instance
	public static function load()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new App();
		}
		return self::$_instance;
	}

	public function set($case, $input)
	{
		return $this->data[$case] = $input;
	}

	public function get($index, $default = null)
	{
		$index = explode('.', $index);
		$data = $this->_getValue($index, $this->data);
		if ($data) {
			return $data;
		}
		return FALSE;
	}

	private function _getValue($index, $value)
	{
		if (is_array($index) and
			count($index)) {
			$current_index = array_shift($index);
		}
		if (is_array($index) and
			count($index) and
			isset($value[$current_index]) and
			is_array($value[$current_index]) and
			count($value[$current_index])) {
			return $this->_getValue($index, $value[$current_index]);
		} elseif (isset($value[$current_index])) {
			return $value[$current_index];
		} else {
			return FALSE;
		}
	}
}
