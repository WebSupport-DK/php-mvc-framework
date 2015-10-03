<?php
/**
 * MVC App
 */
namespace WebSupportDK\PHPMvcFramework;

use WebSupportDK\PHPMvcFramework\Router;

class App extends Router
{

	// object instance 
	private static
		$_instance = null;
	private
		$_data;

	public function bootstrap($params)
	{
		if (!empty($params)) {
			foreach ($params as $key => $value) {
				$this->_info[$key] = $value;
			}
		} else {
			$this->_info = array(
				'controller' => 'default',
				'action' => 'index',
				'root_url' => 'url',
				'path_controllers' => ''
			);
		}
	}

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
		return $this->_data[$case] = $input;
	}

	public function get($index, $default = null)
	{
		$index = explode('.', $index);
		$data = $this->_getValue($index, $this->_data);
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

	public function run($object = null)
	{
		parent::__construct($this->_info, $object);
	}
}
