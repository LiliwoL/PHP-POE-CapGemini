<?php

/**
 * Fichier du noyau de l'application
 * 
 * Contient tous les chargements les déclarations de constantes
 */


namespace App;

use Dotenv\Dotenv;

// Constantes
define('__ROOT__', __DIR__.'/../');

// Autoload
require __ROOT__ . '/vendor/autoload.php';


// Chargement du .env
$dotenv = Dotenv::createImmutable( __ROOT__ );
$dotenv->load();



// Chargement de Twig
$loader = new \Twig\Loader\FilesystemLoader( __ROOT__ . 'templates');
define(
    '__TWIG__',
    new \Twig\Environment(
        $loader, 
        [
            // En fonction du .env, on peut activer ou non le cache
            'cache' => false

            // Activation dans le dossier var
            //'cache' => __ROOT__ . 'var/compilation_cache',
        ]
    )
);