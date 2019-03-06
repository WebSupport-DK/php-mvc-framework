<?php

namespace App\Controllers;

class ErrorController
{

    function __construct()
    {
        
    }
    public function index($code = 404)
    {
           echo $code;
    }

    public function code($code = 404)
    {
        echo $code;
    }

}
