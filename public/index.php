<?php

require dirname(__DIR__).'/vendor/autoload.php';

// Use du namespace 
use App\Entite\Ramette;

// Instance de ramette
$ramette = new Ramette("Xerox", "XB41", "Superbe ramette", 154, 1000, 180);
$ramette->setGrammage(180);

var_dump($ramette);

echo $ramette;