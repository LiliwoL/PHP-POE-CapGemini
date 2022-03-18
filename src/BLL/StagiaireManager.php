<?php

namespace App\BLL;

use DateTime;
use App\Entite\Stagiaire;
use App\DAL\Mapper\StagiaireMapper;

class StagiaireManager
{
    // A la construction, on aura besoin du Mapper
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
    public function creerUnStagiaire( string $nom, string $ddn )
    {
        // Créer l'instance
        $stagiaire = new Stagiaire(
            $nom,
            $ddn = DateTime::createFromFormat('Y-m-d', $ddn)
        );

        // Appel au mapper pour stocker en base
        $this->mapper->insert( $stagiaire );

        // Renvoi de confirmation
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