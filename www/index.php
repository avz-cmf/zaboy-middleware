<?php
// Change to the project root, to simplify resolving paths
chdir(dirname(__DIR__));

// Setup autoloading
require '/vendor/autoload.php';

use Zend\Stratigility\MiddlewarePipe;
use Zend\Diactoros\Server;
use zaboy\middleware\Middleware;


$container = include 'config/container.php';

$app = new MiddlewarePipe();
$head =  new MiddlewarePipe();

$head->pipe('/', new Middleware\HTML\Head()); 
$head->pipe('/', new Middleware\Dojo\DojoInHead());
$head->pipe('/', new Middleware\Dojo\Grid\GetAllRequestHeaders());
$head->pipe('/', new Middleware\Dojo\Grid\GetAllAllType());
$head->pipe('/', new Middleware\Returner()); 


$app->pipe('/HTML', new Middleware\HTML\Html()); 
$app->pipe('/HTML', $head); 
$app->pipe('/HTML', new Middleware\HTML\Body()); 
//$app->pipe('/', new Middleware\WriteURI()); 
$app->pipe('/HTML', new Middleware\Rql\RqlParse());

$app->pipe('/GetAllRequestHeaders', new Middleware\API\Get\GetAllRequestHeaders()); 
$app->pipe('/AllType', $container->get('GetAllAllType')); 


$server = Server::createServer($app,
  $_SERVER,
  $_GET,
  $_POST,
  $_COOKIE,
  $_FILES
);
$server->listen();
