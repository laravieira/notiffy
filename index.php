<?php

require 'vendor/autoload.php';


use Dotenv\Dotenv;
use Mezon\Router\Router;
use Notiffy\NotiffyException;
use Notiffy\NotiffyExecuter;
use Notiffy\NotiffyInterface;

Dotenv::createImmutable(__DIR__)->load();

$router = new Router();
$router->addRoute('/',                        [NotiffyInterface::class, 'home']);
$router->addRoute('/newsletters',             [NotiffyInterface::class, 'list']);
$router->addRoute('/subscribe',               [NotiffyInterface::class, 'subscribe'], ['POST']);
$router->addRoute('/execute',                 [NotiffyExecuter::class, 'execute']);
$router->addRoute('/unsubscribe/[a:n]/[a:k]', [NotiffyInterface::class, 'unsubscribe']);
$router->addRoute('/*', [NotiffyInterface::class, 'notFound'], ['GET', 'POST', 'PUT', 'DELETE']);

try {
    NotiffyInterface::setBlade();
    echo $router->callRoute($_SERVER['REQUEST_URI']);
}catch(NotiffyException $e) {
    // PHPStorm fail when asking you to delete this catch
    $message = array('message' => $e->getMessage());
    echo NotiffyInterface::$blade->render('message', $message);
}