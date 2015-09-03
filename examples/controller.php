<?php

// load classes
require_once '../Controller.php';
require_once '../Model.php';
require_once '../View.php';

// use the controller class
use thom855j\PHPMvc\Controller;

// we create a controller class that extends our main controlelr
class TestController extends Controller
{

    public
            function __construct()
    {
        // we instantiate our parent controller class
        parent::__construct();
    }

    // public index for controller
    public
            function index()
    {
        // data from db or else where
        $data = array(
            'Test' => array(
                'id'   => 2,
                'name' => 'Test'
            )
        );
        
        // render view inside this controllers action
        $this->View->render(array(
            
            // location of view to render
            'views/index'
            
                // the data we want to parse to the view
                ), $data);
    }

}
