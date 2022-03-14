<?php

namespace App\Entite;

class Stylo extends Article
{
    public function __construct(
        string $marque,
        string $reference,
        string $designation,
        float $prixUnitaire,
        int $qteStock,
        private string $couleur,
        ?int $idArticle = null,
    ) {
        parent::__construct($marque, $reference, $designation, $prixUnitaire, $qteStock, $idArticle);
    }

    public function __toString()
    {
        return sprintf(
            "%s Stylo [couleur=%s]\n",
            parent::__toString(),
            $this->couleur
        );
    }

    public function getCouleur(): string
    {
        return $this->couleur;
    }


    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }
}
