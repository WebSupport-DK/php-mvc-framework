<?php

namespace App\Controllers;

class DefaultController
{

    function __construct()
    {
        
    }

    public
            function index($param = 'null')
    {
        echo $param;
    }



}
