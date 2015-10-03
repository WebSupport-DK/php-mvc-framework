<?php
/**
 * MVC App
 */
use WebSupportDK\PHPMvcFramework\Router;

class App extends Router
{

	// object instance 
	private static
		$_instance = null;
	private
		$_data;

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

	public function run($params)
	{
		parent::__construct($params);
	}
}
