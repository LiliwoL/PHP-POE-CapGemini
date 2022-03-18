<?php

// Chargement du noyau de l'application
require dirname(__DIR__).'/src/AppKernel.php';

use App\Controller\ArticleController;
use App\HTTP\Request;
use App\DependencyInjectionContainer;


// Interprétation de la requ^te
// A partir des données serveur, on crée l'objet Request
$request = Request::createFromGlobal();

// Appel au DIC
$dependencyInjectionContainer = DependencyInjectionContainer::getInstance();


// controlleur Article
/**
 * @var ArticleController $articleController
 */
$articleController = $dependencyInjectionContainer->get(ArticleController::class);


// Appel à l'action du controlleur
/**
 * @var Response $response
 */
//$response = $articleController->listStylos( $request );
//$response = $articleController->listRamettes( $request );
$response = $articleController->listArticles( $request );


// Invoke Response

// Appel à la méthode magique php __invoke()
// https://www.php.net/manual/fr/language.oop5.magic.php#object.invoke
$response();