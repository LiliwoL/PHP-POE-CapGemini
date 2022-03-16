<?php

require dirname(__DIR__).'/vendor/autoload.php';

// Use du namespace 

use App\BLL\StagiaireManager;
use Dotenv\Dotenv;
use App\Entite\Stylo;
use App\Entite\Ramette;
use App\DAL\Storage\Database;
use App\DependencyInjectionContainer;

/*
    ****************** Entités *******************
*/
// Instance de ramette
    $ramette = new Ramette("Xerox", "XB41", "Superbe ramette", 154, 1000, 180);
    $ramette->setGrammage(180);

    var_dump($ramette);
    echo "En utilisant la méthode __toString(): " . $ramette;

// Instance de Style
    $stylo = new Stylo("Pilot", "5", "bien comme stylo", 5, 10000, "noir");
    var_dump($stylo);
    echo "Mon stylo: " .$stylo;


/*
    ****************************** DAL *********
*/

// Chargement du .env
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Récupération de l'Instance de la Database
$database = Database::getInstance();
var_dump($database);

// Lancement d'une requête
$articles = $database
            ->getDbh()
            ->query('SELECT * FROM articles')
            ->fetchAll(PDO::FETCH_ASSOC);

var_dump($articles);

/*
    ****************************** Dependancy Injection *********
*/

/* $dependencyInjectionContainer = DependencyInjectionContainer::getInstance();

// Affichage de toutes les deps
$dependencyInjectionContainer->listDependencies();

echo "Quelle dépendance?";
var_dump($dependencyInjectionContainer->get(StagiaireMapper::class));

echo "A quoi correspond StagiaireMapper::class:" . StagiaireMapper::class;

// Affichage de toutes les deps
$dependencyInjectionContainer->listDependencies();
 */

/*
    ****************** Stagiaire Manager ************
*/

$dependencyInjectionContainer = DependencyInjectionContainer::getInstance();

// Créer un stagiaire depuis le contrôleur frontal
$stagiaireManager = $dependencyInjectionContainer->get(StagiaireManager::class);

$stagiaireManager->creerUnStagiaire( "Nicolas" );