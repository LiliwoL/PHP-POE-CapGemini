<?php

require dirname(__DIR__).'/vendor/autoload.php';

// Use du namespace 
use App\Entite\Ramette;

// Instance de ramette
$ramette = new Ramette("Xerox");
$ramette->setGrammage(180);

var_dump($ramette);