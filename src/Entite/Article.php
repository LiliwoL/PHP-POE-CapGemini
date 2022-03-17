<?php

namespace App\Entite;

use JsonSerializable;

abstract class Article implements JsonSerializable
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

    public function getPrixUnitaire(): float
    {
        return $this->prixUnitaire;
    }

    public function getIdArticle(): int
    {
        return $this->idArticle;
    }

    public function getMarque(): string
    {
        return $this->marque;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getDesignation(): string
    {
        return $this->designation;
    }

    public function getQteStock(): int
    {
        return $this->qteStock;
    }

    public function setPrixUnitaire(float $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function setQteStock(int $qteStock): self
    {
        $this->qteStock = $qteStock;

        return $this;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
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
