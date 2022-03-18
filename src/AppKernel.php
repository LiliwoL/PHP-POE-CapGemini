<?php

namespace App;

use Dotenv\Dotenv;

define('__ROOT__', __DIR__.'/../');

require __ROOT__ . '/vendor/autoload.php';

// Chargement du .env
$dotenv = Dotenv::createImmutable( __ROOT__ );
$dotenv->load();

// Chargement de Twig
$loader = new \Twig\Loader\FilesystemLoader( __ROOT__ . 'templates');
define(
    '__TWIG__',
    new \Twig\Environment($loader, [
        'cache' => __ROOT__ . 'var/compilation_cache',
    ])
);