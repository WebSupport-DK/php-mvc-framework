<?php
/*
 * The default model all other models extends for db access
 */

namespace PHP\MVC;

use PHP\Crud\Database;

abstract class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::singleton();
    }
}
