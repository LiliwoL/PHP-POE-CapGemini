<?php
namespace App\Entite;

class Stagiaire{

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
        // On devrait vértifier le contenu de $state

        // Renvoi d'une instance de l'entité
        return new self(
            $state['nom'],
            $state['identifiant']
        );
    }
}