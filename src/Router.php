<?php
/**
 * Router Class
 *
 * Responsible for fechting the write controller-classes
 * and methods according to the "index.php?url=[controller class]/[method]/[parameters]"  URL.
 * protected $variable = Only accessible inside this class and childs!
 */
namespace WebSupportDK\PHPMvcFramework;

class Router
{

// class params
	protected
		$_path,
		$_QS,
		$_controller,
		$_action,
		$_params = array(),
		$_url;

	/*
	 * Construct with default values
	 */
	public function __construct()
	{
		$this->_path = '';
		$this->_controller = 'default';
		$this->_action = 'index';
		$this->_QS = 'url';
	}

	/**
	 * Set path to controllers
	 * @param type $path
	 */
	public function setControllersPath($path)
	{
		$this->_path = $path;
	}

	/**
	 * Set default controller
	 * 
	 * @param type $name
	 */
	public function setDefaultController($name)
	{
		$this->_controller = $name;
	}

	/**
	 * Set default action
	 * 
	 * @param type $name
	 */
	public function setDefaultAction($name)
	{
		$this->_action = $name;
	}
	
	/**
	 * Set default query string from $_GET
	 * 
	 * @param type $name
	 */
	public function setQueryString($name)
	{
		$_QS = $name;
	}

	/**
	 * Fetching the controller class and its methods
	 * happens in the contructer doing every run.
	 * Default params are:
	 * array('controller' =>'default','action'=>'index','path_controllers' => '', 'root_url'=> 'url')
	 * $object can be something to pass to the controllers constructer
	 */
	public function run($params = null)
	{

		// use this class method to parse the $_GET[url]
		$this->_url = $this->_parseUrl($this->_QS);

		if (!empty($this->_url)) {
			$this->_controller = ucfirst($this->_url[0]);
		} else {
			$this->_url = array($this->_controller, $this->_action);
		}

		// checks if a controller by the name from the URL exists
		if (ctype_lower(str_replace('_', '', $this->_url[0])) && file_exists($this->_path . $this->_controller . 'Controller.php')) {

			// if exists, use this as the controller instead of default
			$this->_controller = ucfirst($this->_controller) . 'Controller';

			/*
			 * destroys the first URL parameter,
			 *  to leave it like index.php?url=[0]/[1]/[parameters in array seperated by "/"]
			 */
			unset($this->_url[0]);
		} else {
			return header("HTTP/1.0 404 Not Found");
		}


		// use the default controller if file NOT exists, or else use the controller name from the URL
		require_once $this->_path . $this->_controller . '.php';

		// initiate the controller class as an new object
		$this->_controller = new $this->_controller($params);

		// checks for if a second url parameter like index.php?url=[0]/[1] is set
		if (!empty($this->_url)) {

			// then check if an according method exists in the controller from $url[0]
			if (method_exists($this->_controller, $this->_url[1])) {

				// if exists, use this as the method instead of default
				$this->_action = $this->_url[1];

				/*
				 * destroys the second URL, to leave only the parameters
				 *  left like like index.php?url=[parameters in array seperated by "/"]
				 */
				unset($this->_url[1]);
			} else {
				return header("HTTP/1.0 404 Not Found");
			}
		}

		/**
		 * checks if the $_GET['url'] has any parameters left in the
		 * index.php?url=[parameters in array seperated by "/"].
		 * If it has, get all the values. Else, just parse is as an empty array.
		 */
		$this->_params = $this->_url ? array_values($this->_url) : array();

		/**
		 * 1. call/execute the controller and it's method.
		 * 2. If the Router has NOT changed them, use the default controller and method.
		 * 2. if there are any params, return these too. Else just return an empty array.
		 */
		call_user_func_array(array($this->_controller, $this->_action), $this->_params);
	}

	/**
	 * The parUrl method is responsible for getting the $_GET['url']-parameters
	 * as an array, for sanitizing it for anything we don't want and removing "/"-slashes
	 * after the URL-parameter
	 */
	private function _parseUrl($name)
	{

		if (isset($_GET[$name])) {
			return explode('/', filter_var(rtrim($_GET[$name], '/'), FILTER_SANITIZE_URL));
		}
		return FALSE;
	}
}
