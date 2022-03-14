<?php

namespace App\Entite;

abstract class Article
{
    // Attributes
    private string $_marque;

    // Constructeur
    public function __construct( $marque )
    {
       $this->_marque = $marque;
    }

    // Méthode toString
    public function __toString()
    {
        return "";
    }

    /*
        Getters et Setters
    */
}