<?php

require dirname(__DIR__).'/vendor/autoload.php';

// Use du namespace 

use Dotenv\Dotenv;
use App\HTTP\Request;
use App\Http\Response;
use App\DependencyInjectionContainer;
use App\Controller\StagiaireController;


// Chargement du .env
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

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
$response = $stagiaireController->list( $request );

// Invoke Response

// Appel à la méthode magique php __invoke()
// https://www.php.net/manual/fr/language.oop5.magic.php#object.invoke
$response();