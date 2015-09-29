<?php
/*
 * The default model all other models extends for db access
 */
namespace WebSupportDK\PHPMvcFramework;

use WebSupportDK\PHPScrud\DB;

class Model
{

	protected $_db;

	protected function __construct()
	{
		$this->_db = DB::load();
	}
}
