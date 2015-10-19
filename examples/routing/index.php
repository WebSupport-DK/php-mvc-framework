<?php

ini_set('display_errors', true);
// load
require_once '../../src/Router.php';
require_once '../../src/App.php';

// manuelly loading the controllers (Easier with composer)
require_once 'App/Controllers/DefaultController.php';
require_once 'App/Controllers/ErrorController.php';
require_once 'App/Controllers/HomeController.php';

use WebSupportDK\PHPMvcFramework\App;

// Load app
$app = App::load();

// Config Router
$app->set('Router', new WebSupportDK\PHPMvcFramework\Router);
$app->get('Router')->setControllersPath('App/Controllers/');
$app->get('Router')->setDefaultController('Default');
$app->get('Router')->setDefaultAction('index');
$app->get('Router')->setQueryString('url');
$app->get('Router')->setNamespace("App\Controllers");

print_r($app->get('Router'));

// Run Router
$app->get('Router')->run();

