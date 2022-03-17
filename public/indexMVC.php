<?php

require dirname(__DIR__).'/vendor/autoload.php';

// Use du namespace 

use Dotenv\Dotenv;
use App\Entite\Stylo;
use App\HTTP\Request;
use App\Http\Response;
use App\Entite\Ramette;
use App\BLL\ArticleManager;
use App\BLL\StagiaireManager;
use App\DAL\Storage\Database;
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
$stagiaireController = $dependencyInjectionContainer->get(StagiaireController::class);

// Appel à l'action list
/**
 * @var Response $response
 */
$response = $stagiaireController->list( $request );

// Invoke Response
$response();