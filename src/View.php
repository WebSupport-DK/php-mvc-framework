<?php
/**
 * Class View
 * The part that handles all the output
 */
namespace WebSupportDK\PHPMvcFramework;

class View
{

	// object instance 
	private static $_instance = null;
	private $_templates;

	public static function load()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new View();
		}
		return self::$_instance;
	}

	/**
	 * simply includes (=shows) the view. this is done from the controller. In the controller, you usually say
	 * $this->view->render('help/index'); to show (in this example) the view index.php in the folder help.
	 * Usually the Class and the method are the same like the view, but sometimes you need to show different views.
	 * @param string $filename Path of the to-be-rendered view, usually folder/file(.php)
	 * @param array $data Data to be used in the view
	 */
	public function render($filenames = array(), $data = null)
	{
		// parsing data
		if ($data) {
			foreach ($data as $key => $value) {
				$this->{$key} = $value;
			}
		}

		// requireing views
		foreach ($filenames as $filename) {
			$this->_templates['path'] . $this->_templates['template'] . $filename . '.php';
		}
	}

	/**
	 * Renders pure JSON to the browser, useful for API construction
	 * @param $data
	 */
	public function renderJson($data)
	{
		echo json_encode($data);
	}

	/**
	 * render feedback messages into the view
	 */
	public function renderFeedback()
	{
		// echo out the feedback messages (errors and success messages etc.),
		// they are in $_SESSION["feedback_positive"] and $_SESSION["feedback_negative"]
		require_once $this->_templates['feedback'];
		// delete these messages (as they are not needed anymore and we want to avoid to show them twice
	}

	public function setTemplatesPath($path)
	{
		$this->_templates['path'] = $path . DIRECTORY_SEPARATOR;
	}

	public function setFeedbackFile($file)
	{
		$this->_templates['feedback'] = $file . '.php';
	}

	public function setTemplate($template = '')
	{
		$this->_templates['template'] = $template . DIRECTORY_SEPARATOR;
	}
}
