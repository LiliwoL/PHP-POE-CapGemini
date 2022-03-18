<?php

require dirname(__DIR__).'/AppKernel.php';

// Use du namespace 
use App\HTTP\Request;
use App\Http\Response;
use App\DependencyInjectionContainer;
use App\Controller\StagiaireController;

/*
    ****************** Stagiaire Controller ************
*/

// A partir des données serveur, on crée l'objet Request
$request = Request::createFromGlobal();

// Dépendances pour le StagiaireController
$dependencyInjectionContainer = DependencyInjectionContainer::getInstance();

/**
 * @var StagiaireController $stagiaireController
 */
$stagiaireController = $dependencyInjectionContainer->get( StagiaireController::class );

// Appel à l'action list
/**
 * @var Response $response
 */
$response = $stagiaireController->listView( $request );

// Invoke Response

// Appel à la méthode magique php __invoke()
// https://www.php.net/manual/fr/language.oop5.magic.php#object.invoke
$response();