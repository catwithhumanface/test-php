<?php
// Start session
session_start();

// Your configuration
require('config.php');

require('classes/Install.php');
require('classes/Messages.php');
require('classes/Bootstrap.php');
require('classes/Controller.php');
require('classes/Model.php');

require('controllers/home.php');
require('controllers/blog.php');
require('controllers/users.php');

require('models/home.php');
require('models/blog.php');
require('models/user.php');

new Install();

$bootstrap = new Bootstrap($_GET);
$controller = $bootstrap->createController();
if ($controller) {
    $controller->executeAction();
}