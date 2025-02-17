<?php
require __DIR__.'/../../vendor/autoload.php';
require __DIR__.'/../../routes/web.php';

use SimpleW\Router;

$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);