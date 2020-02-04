<?php
/*
 * The default model all other models extends for db access
 */

namespace PHP\MVC;

abstract class Model
{
    protected $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
}
