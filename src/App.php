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

	public function __construct($params)
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

	public function register($case, $input)
	{
		static $data = array();
		array_push($data, $input);
		return $this->_data[$case] = $data;
	}

	public function get($case)
	{
		return $this->_data[$case];
	}

	public function run()
	{
		parent::__construct($this->_info);
	}
}
