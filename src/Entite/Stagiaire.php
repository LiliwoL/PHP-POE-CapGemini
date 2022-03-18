<?php
namespace App\Entite;

use DateTime;
use JsonSerializable;

class Stagiaire implements JsonSerializable
{

    public function __construct(private string $nom, private ?DateTime $ddn = null, private ?int $identifiant = null){
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

    public function getDdn(): ?DateTime
    {
        return $this->ddn;
    }

    public function setDdn(DateTime $ddn): self
    {
        $this->ddn = $ddn;

        return $this;
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
            $state['ddn'],
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
        return [
            'nom' => $this->getNom(),
            'ddn' => $this->getDdn()->format('Y-m-d'),
            'identifiant' => $this->getIdentifiant(),
        ];
    }
}