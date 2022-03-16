<?php

namespace App\DAL\Mapper;

// L'interface uniquement, pas besoin de MySQL ou InMemory
use App\DAL\Storage\StagiaireStorage;

// L'entité stagiaire
use App\Entite\Stagiaire;

use InvalidArgumentException;
use ArrayObject;

/**
 * Stagiaire Mapper
 * fait la liaison entre l'entité et le stockage
 * Attend un StagiaireStorage (qui est une interface)
 */
class StagiaireMapper
{
    // Constructeur qui fait également la déclaration de l'attribut $stagiaireStorage
    public function __construct(private StagiaireStorage $stagiaireStorage){}

    // Méthode pour persister en base un stagiaire
    public function insert( Stagiaire $stagiaire )
    {
        // Appel à la méthode insert du storage
        // La méthode renvoie un entier, ici, on n'en fait rien
        $this->stagiaireStorage->insert( $stagiaire->getNom() );
    }

    // Méthode pour findById
    // Elle renverra une entité Stagiaire
    public function findById( int $id ) : Stagiaire
    {
        // Méthode find des storages
        // On récupère soit null, soit un tableau
        $result = $this->stagiaireStorage->find( $id );

        if ( $result === null )
        {
            throw new InvalidArgumentException("Stagiaire #$id not found");
        }

        // Utilisation d'une méthode qui va transformer un tableau en entité Stagiaire
        return Stagiaire::fromState($result);
    }

    // Méthode update
    public function update( Stagiaire $stagiaire )
    {
        // Appel à la méthode update du storage
        $this->stagiaireStorage->update(
            $stagiaire->getNom(),
            $stagiaire->getIdentifiant()
        );
    }

    // Renvoi d'un tableau d'objets Stagiaire
    public function findAll(): ArrayObject
    {
        // La méthode findall renvoie un tableau de tableau
        $results = $this->stagiaireStorage->findAll();

        // On veut un tableau d'objets
        $collection = new ArrayObject();

        foreach ( $results as $stagiaire )
        {
            $collection->append(
                // Transformation du tableau en entité Stagiaire
                Stagiaire::fromState( $stagiaire )
            );
        }

        return $collection;
    }

    public function delete( int $id )
    {
        // Renvoie un entier
        $this->stagiaireStorage->delete( $id );
    }
}