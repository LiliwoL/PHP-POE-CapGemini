<?php

require dirname(__DIR__).'/vendor/autoload.php';

// Use du namespace 
use App\Entite\Ramette;
use App\Entite\Stylo;

// Instance de ramette
    $ramette = new Ramette("Xerox", "XB41", "Superbe ramette", 154, 1000, 180);
    $ramette->setGrammage(180);

    var_dump($ramette);
    echo "En utilisant la méthode __toString(): " . $ramette;

// Instance de Style
    $stylo = new Stylo("Pilot", "5", "bien comme stylo", 5, 10000, "noir");
    var_dump($stylo);
    echo "Mon stylo: " .$stylo;