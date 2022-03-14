<?php

namespace App\Entite;

class Panier
{
    public function __construct(
        private ?Collection $lignes = null,
        private float $montant = 0
    ) {
        $this->lignes = $lignes ?? new Collection();
    }

    public function addLigne(Ligne $ligne): self
    {
        $this->lignes->append($ligne);

        return $this;
    }

    public function removeLigne(Ligne $ligne): self
    {
        $this->lignes->remove($ligne);

        return $this;
    }

    public function getLignes(): Collection
    {
        return $this->lignes;
    }

    public function getMontant(): float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }
}
