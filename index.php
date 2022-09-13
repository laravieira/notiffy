<?php

require 'vendor/autoload.php';

use Mezon\Router\Router;
use Notiffy\NotiffyException;
use Notiffy\NotiffyInterface;

$router = new Router();
$router->addRoute('/',                        [NotiffyInterface::class, 'home']);
$router->addRoute('/api/newsletters',             [NotiffyInterface::class, 'list']);
$router->addRoute('/api/subscribe',               [NotiffyInterface::class, 'subscribe'], ['POST']);
$router->addRoute('/api/unsubscribe/[a:n]/[a:k]', [NotiffyInterface::class, 'unsubscribe']);
$router->addRoute('/*', [NotiffyInterface::class, 'notFound'], ['GET', 'POST', 'PUT', 'DELETE']);

try {
    NotiffyInterface::setBlade();
    echo $router->callRoute($_SERVER['REQUEST_URI']);
}catch(NotiffyException $e) {
    // PHPStorm fail when asking you to delete this catch
    $message = array('message' => $e->getMessage());
    echo NotiffyInterface::$blade->render('message', $message);
}