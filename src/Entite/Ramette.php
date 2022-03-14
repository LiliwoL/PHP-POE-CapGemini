<?php

namespace App\Entite;

class Ramette extends Article
{
    // Attributs
    private int $_grammage;

    // Constructeur
    public function __construct( $marque )
    {
        // Constructeur parent
       parent::__construct($marque);
    }

    // Méthode toString
    public function __toString()
    {
        return "Je suis une ramette de grammage: " . $this->_grammage;
    }

   

    /*
        Getters et Setters
    */
    public function setGrammage( int $grammage )
    {
        $this->_grammage = $grammage;

        return $this;
    }
}