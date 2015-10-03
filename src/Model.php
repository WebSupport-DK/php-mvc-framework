<?php
/*
 * The default model all other models extends for db access
 */
namespace WebSupportDK\PHPMvcFramework;

use WebSupportDK\PHPScrud\DB;

class Model
{

	protected $_DB;

	protected function __construct()
	{
		$this->_DB = DB::load();
	}
}
