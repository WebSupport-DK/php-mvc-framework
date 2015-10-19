<?php

// load classes
require_once '../src/Controller.php';
require_once '../src/Model.php';
require_once '../src/View.php';

// use the controller class
use WebSupportDK\PHPMvcFramework\Controller,
 WebSupportDK\PHPMvcFramework\Model;

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
        // data from db or else where. 
        // the model is an abstract example of how a model can be created.
        // this one is set to function together with PHPSql\DB class.
        $data = Model::load()->read();
        
        // render view inside this controllers action
        $this->View->render(array(
            
            // location of view to render
            'views/index'
            
                // the data we want to parse to the view
                ), $data);
    }

}
