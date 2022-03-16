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
}