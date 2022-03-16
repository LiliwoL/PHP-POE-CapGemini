<?php

namespace App\BLL;

use App\DAL\Mapper\StagiaireMapper;
use App\Entite\Stagiaire;

class StagiaireManager
{
    // A la construction, on aura besoin du Mappe
    // On utilise la syntaxe PHP 8 (attribut automatiquement créé)
    public function __construct( 
        private StagiaireMapper $mapper
    ) {}

    /**
     * Undocumented function
     *
     * @param string $nom
     * @return void
     */
    public function creerUnStagiaire( string $nom )
    {
        // Créer l'instance
        $stagiaire = new Stagiaire( $nom );

        // Appel au mapper pour stocker en base
        $this->mapper->insert( $stagiaire );
    }

    /**
     * Undocumented function
     *
     * @return ArrayObject
     */
    public function listerLesStagiaires()
    {
        // Methode du mapper
        return $this->mapper->findAll();
    }
}