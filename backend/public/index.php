<?php

require '../vendor/autoload.php';

use App\Controller\News\GoogleNewsController;
use App\Kernel\Request;
use App\Kernel\Response;
use App\Kernel\Router;
use Dotenv\Dotenv;

// Initialize the Dotenv
$dotenv = Dotenv::createImmutable(realpath(__DIR__ . '/..'));
$dotenv->safeLoad();

// Create the router
$router = new Router();

// Create a new Request object with the $_GET array.
$request = new Request($_GET);

// Default request
$router->add('/', function() {
    Response::jsonResponse(["You have reached the News API"]);
});

// Google News RSS request
$router->add('/news/google', function() use ($request) {
    $googleNewsController =  new GoogleNewsController();
    $googleNewsController->index($request);
});

// Start the router
$router->run();

