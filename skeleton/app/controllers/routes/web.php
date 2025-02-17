<?php

use SimpleW\Router;

$router = new Router();

$router->addRoute('/', 'HomeController@index');