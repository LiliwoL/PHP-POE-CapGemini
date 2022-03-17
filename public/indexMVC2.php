<?php

use App\Controller\ArticleController;
use App\DependencyInjectionContainer;
use App\Http\Request;
use Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$request = Request::createFromGlobal();

$dependencyInjectionContainer = DependencyInjectionContainer::getInstance();

$articleController = $dependencyInjectionContainer->get(ArticleController::class);

$response = $articleController->listStylos($request);

$response();