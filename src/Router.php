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
		$_info,
		$_url,
		$_params = array();

	/**
	 * Fetching the controller class and its methods
	 * happens in the contructer doing every run.
	 * Default params are:
	 * array('controller' =>'default','action'=>'index','path_controllers' => '', 'root_url'=> 'url')
	 */
	public function __construct($params = array(), $object = null)
	{
		if (empty($params)) {
			return FALSE;
		}

		foreach ($params as $key => $value) {
			$this->_info[$key] = $value;
		}

		// use this class method to parse the $_GET[url]
		$this->_url = $this->_parseUrl($this->_info['root_url']);

		if (!empty($this->_url)) {
			$this->_info['controller'] = ucfirst($this->_url[0]);
		} else {
			$this->_url = array($this->_info['controller'], $this->_info['action']);
		}

		// checks if a controller by the name from the URL exists
		if (ctype_lower(str_replace('_', '', $this->_url[0])) && file_exists($this->_info['path_controllers'] . $this->_info['controller'] . 'Controller.php')) {

			// if exists, use this as the controller instead of default
			$this->_info['controller'] = $this->_info['controller'] . 'Controller';

			/*
			 * destroys the first URL parameter,
			 *  to leave it like index.php?url=[0]/[1]/[parameters in array seperated by "/"]
			 */
			unset($this->_url[0]);
		} else {
			return header("HTTP/1.0 404 Not Found");
		}

		#var_dump($path);
		// use the default controller if file NOT exists, or else use the controller name from the URL
		require_once $this->_info['path_controllers'] . $this->_info['controller'] . '.php';

		// initiate the controller class as an new object
		$this->_info['controller'] = new $this->_info['controller']($object);

		// checks for if a second url parameter like index.php?url=[0]/[1] is set
		if (!empty($this->_url)) {

			// then check if an according method exists in the controller from $url[0]
			if (method_exists($this->_info['controller'], $this->_url[1])) {

				// if exists, use this as the method instead of default
				$this->_info['action'] = $this->_url[1];

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
		call_user_func_array(array($this->_info['controller'], $this->_info['action']), $this->_params);
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
