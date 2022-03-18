<?php

// Chargement du noyau de l'application
require dirname(__DIR__).'/src/AppKernel.php';


use App\HTTP\Request;
use App\DependencyInjectionContainer;
use App\Controller\StagiaireController;



// Interprétation de la requ^te
// A partir des données serveur, on crée l'objet Request
$request = Request::createFromGlobal();

// Appel au DIC
$dependencyInjectionContainer = DependencyInjectionContainer::getInstance();

/**
 * @var StagiaireController $stagiaireController
 */
$stagiaireController = $dependencyInjectionContainer->get( StagiaireController::class );

// Appel à l'action du controlleur
/**
 * @var Response $response
 */
$response = $stagiaireController->listView( $request );

// Invoke Response

// Appel à la méthode magique php __invoke()
// https://www.php.net/manual/fr/language.oop5.magic.php#object.invoke
$response();