<?php
namespace App\Entite;

use JsonSerializable;

class Stagiaire implements JsonSerializable
{

    public function __construct(private string $nom, private ?int $identifiant = null){
    }

    public function getNom(){
        return $this->nom;
    }

    public function setNom(string $nom){
        $this->nom = $nom;
    }

    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    /**
     * Méthode static qui va transformer un tableau en entité Stagiaire
     *
     * @param array $state
     * @return Stagiaire
     */
    public static function fromState( array $state ) : Stagiaire
    {
        // On devrait vérifier le contenu de $state !!

        // Renvoi d'une instance de l'entité
        return new self(
            $state['nom'],
            $state['identifiant']
        );
    }

    /**
     * Pour faire du json_decode sur les attributs privés
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return get_object_vars( $this );
    }
}