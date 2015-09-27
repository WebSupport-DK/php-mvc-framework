<?php

ini_set('display_errors', true);
// load
require_once '../../src/Router.php';
require_once '../../src/Url.php';

//// use class
//use thom855j\PHPHttp\Router;
//
//// return a controller from url with query "index?url"
//// and the paths to controllers to look ind
//$router = new Router('url', 'path/to/controllers/');
//
//// returns current host
//Router::getHost();
//
//// current root of current project url.
//// If project rewrites inside a folder, it can be removed from the return url
//Router::getProjectUrl($path = '');
//
//// return url protocol
//Router::getProtocol();
//
//// returns all of current url
//Router::getUrl();
//
//// return either the $_GET url in form of array or string if array is true or false
//Router::parseUrl($name = '', $array = null);
use thom855j\PHPMvcFramework\Router;

Router::load(
        array(
            'controller'      => 'test',
            'action'          => 'index',
            'root_url'        => 'url',
            'path_controller' => ''
        )
)->run();

