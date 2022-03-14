<?php

namespace App\Entite;

class Ramette extends Article
{
    public function __construct(
        string $marque,
        string $reference,
        string $designation,
        float $prixUnitaire,
        int $qteStock,
        private int $grammage,
        ?int $idArticle = null,
    ) {
        parent::__construct($marque, $reference, $designation, $prixUnitaire, $qteStock, $idArticle);
    }

    public function __toString()
    {
        return sprintf(
            "%s Ramette [grammage=%s]\n",
            parent::__toString(),
            $this->grammage
        );
    }

   

    /*
        Getters et Setters
    */
    public function setGrammage( int $grammage )
    {
        $this->_grammage = $grammage;

        return $this;
    }
}