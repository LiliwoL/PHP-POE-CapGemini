<?php

use App\Router;

// Chargement du noyau de l'application
require dirname(__DIR__).'/src/AppKernel.php';

$router = new Router();

$router();