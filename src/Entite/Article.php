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

    /*
        Getters et Setters
    */
}