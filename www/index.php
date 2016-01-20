<?php
// Change to the project root, to simplify resolving paths
chdir(dirname(__DIR__));

// Setup autoloading
require '/vendor/autoload.php';

use zaboy\res\Middleware\GetById;
use Zend\Stratigility\MiddlewarePipe;
use Zend\Diactoros\Server;

$container = include 'config/container.php';

$app    = new MiddlewarePipe();
$GetById = new GetById();
$app->pipe('/', $GetById); 

$server = Server::createServer($app,
  $_SERVER,
  $_GET,
  $_POST,
  $_COOKIE,
  $_FILES
);
$server->listen();
