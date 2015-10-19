<?php
require '../src/App.php';

// Load class
use WebSupportDK\PHPMvcFramework\App;
$app = App::load();

// Set something
$app->set('Menu', array('<ul>', '</ul>'));

// Add something to it
$app->add('Menu', '<li>1</li>',1);
$app->add('Menu', '<li>2</li>',2);
$app->add('Menu', '<li>3</li>',3);

// Get something from it
print_r($app->get('Menu'));