<?php

/*
 * Router Class 
 *  
 * responsible for fechting the write controller-classes  
 * and methods according to the "index.php?url=[controller class]/[method]/[parameters]"  URL. 
 * protected $variable = Only accessible inside this class and childs! 
 */

namespace thom855j\PHPMvcFramework;

class Router
{

    // object instance
    private static
            $_instance = null;
    // class params
    protected
            $data;
    //url
    public
            $url,
            $params            = array();

    /*
     * fetching the controller class and its methods  
     * happens in the contructer doing every run 
     */

    public
            function __construct($params = array())
    {
        if (!empty($params))
        {
            foreach ($params as $key => $value)
            {
                $this->data[$key] = $value;
            }
        }
        else
        {
            $this->data = array(
                'controller'      => 'default',
                'action'          => 'index',
                'root_url'        => 'url',
                'path_controller' => ''
            );
        }
        // use this class method to parse the $_GET[url] 
        $this->url = self::parseUrl($this->data['root_url']);

        if (!empty($this->url))
        {
            $this->data['controller'] = ucfirst($this->url[0]);
        }
        else
        {
            $this->url = array($this->data['controller'], $this->data['action']);
        }
    }

    /*
     * Instantiate object
     */

    public static
            function load($params = array())
    {
        if (!isset(self::$_instance))
        {
            self::$_instance = new Router($params          = array());
        }
        return self::$_instance;
    }

    public
            function run()
    {

        // checks if a controller by the name from the URL exists 
        if (ctype_lower(str_replace('_', '', $this->url[0])) && file_exists($this->data['path_controller'] . $this->data['controller'] . 'Controller.php'))
        {

            // if exists, use this as the controller instead of default 
            $this->data['controller'] = $this->data['controller'] . 'Controller';

            /*
             * destroys the first URL parameter, 
             *  to leave it like index.php?url=[0]/[1]/[parameters in array seperated by "/"] 
             */
            unset($this->url[0]);
        }
        else
        {
            return header("HTTP/1.0 404 Not Found");
        }

        #var_dump($path);
        // use the default controller if file NOT exists, or else use the controller name from the URL 
        require_once $this->data['path_controller'] . $this->data['controller'] . '.php';

        // initiate the controller class as an new object 
        $this->data['controller'] = new $this->data['controller'];

        // checks for if a second url parameter like index.php?url=[0]/[1] is set 
        if (!empty($this->url))
        {

            // then check if an according method exists in the controller from $url[0] 
            if (method_exists($this->data['controller'], $this->url[1]))
            {

                // if exists, use this as the method instead of default 
                $this->data['action'] = $this->url[1];

                /*
                 * destroys the second URL, to leave only the parameters 
                 *  left like like index.php?url=[parameters in array seperated by "/"] 
                 */
                unset($this->url[1]);
            }
            else
            {
                return header("HTTP/1.0 404 Not Found");
            }
        }

        /*
         * checks if the $_GET['url'] has any parameters left in the   
         * index.php?url=[parameters in array seperated by "/"]. 
         * If it has, get all the values. Else, just parse is as an empty array. 
         */
        $this->params = $this->url ? array_values($this->url) : array();

        /*
         * 1. call/execute the controller and it's method.  
         * 2. If the Router has NOT changed them, use the default controller and method. 
         * 2. if there are any params, return these too. Else just return an empty array. 
         */
        call_user_func_array(array($this->data['controller'], $this->data['action']),
                             $this->params);
    }

    /*
     * The parUrl method is responsible for getting the $_GET['url']-parameters  
     * as an array, for sanitizing it for anything we don't want and removing "/"-slashes  
     * after the URL-parameter 
     */

    public static
            function parseUrl($name, $array = true)
    {

        if (isset($_GET[$name]) && $array === true)
        {
            return explode('/',
                           filter_var(rtrim($_GET[$name], '/'),
                                            FILTER_SANITIZE_URL));
        }
        elseif (isset($_GET[$name]) && $array === false)
        {
            return filter_var(rtrim($_GET[$name], '/'), FILTER_SANITIZE_URL);
        }
        else
        {
            return false;
        }
    }

}
