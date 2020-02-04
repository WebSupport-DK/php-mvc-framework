<?php
/**
 * This is the "base controller class". All other "real" controllers extend this class.
 * Whenever a controller is created, we also
 * 1. initialize a session
 * 2. check if the user is not logged in anymore (session timeout) but has a cookie
 */

namespace Datalaere\PHPMvcFramework;

abstract class Controller
{

    /** @var View View The view object */
    protected $view;
    protected $container;

    /**
     * Construct the (base) controller. This happens when a real controller is constructed, like in
     * the constructor of IndexController when it says: parent::__construct();
     */
    public function __construct($view, $container)
    {
        // create a view object to be able to use it inside a controller, like $this->View
        $this->view = $view;

        // create a app object to be able to use it inside a controller, like $this->App
        $this->container = $container;
    }
}
