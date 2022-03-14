<?php

namespace App\Entite;

abstract class Article
{
    public function __construct(
        private string $marque,
        private string $reference,
        private string $designation,
        private float $prixUnitaire,
        private int $qteStock,
        private ?int $idArticle = null,
    ) {
    }

    public function __toString()
    {
        return sprintf(
            "Article [idArticle=%s, marque=%s, reference=%s, designation=%s, prixUnitaire=%s, qteStock=%s]\n",
            $this->idArticle,
            $this->marque,
            $this->reference,
            $this->designation,
            $this->prixUnitaire,
            $this->qteStock,
        );
    }
    
    /*
        Getters et Setters
    */
}