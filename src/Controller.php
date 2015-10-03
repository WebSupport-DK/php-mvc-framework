<?php
/**
 * This is the "base controller class". All other "real" controllers extend this class.
 * Whenever a controller is created, we also
 * 1. initialize a session
 * 2. check if the user is not logged in anymore (session timeout) but has a cookie
 */
namespace WebSupportDK\PHPMvcFramework;

use WebSupportDK\PHPMvcFramework\View;
use WebSupportDK\PHPMvcFramework\App;

class Controller
{

	/** @var View View The view object */
	public $View;
	protected $_App;

	/**
	 * Construct the (base) controller. This happens when a real controller is constructed, like in
	 * the constructor of IndexController when it says: parent::__construct();
	 */
	protected function __construct()
	{
		// always initialize a session, if it not exists
		if (session_id() == '') {
			session_cache_limiter(false);
			session_start();
		}

		// create a view object to be able to use it inside a controller, like $this->View
		$this->View = View::load();
		// create a app object to be able to use it inside a controller, like $this->App
		$this->_App = App::load();
	}
}
