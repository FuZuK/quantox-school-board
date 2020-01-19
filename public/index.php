<?php
include_once '../vendor/autoload.php';

$config = require('../etc/config.php');
$routes = require('../etc/routes.php');

$app = new Application($config, $routes);
$app->run();
