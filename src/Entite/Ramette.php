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
    public function getGrammage(): int
    {
        return $this->grammage;
    }

    public function setGrammage(int $grammage): self
    {
        $this->grammage = $grammage;

        return $this;
    }

    /**
     * Transformation d'un tableau en entité Ramette
     * 
     * @param $state Tableau associatif correspondant à un Ramette
     * @return Ramette Renvoi une entité Ramette
     */
    public static function fromState(array $state): Ramette
    {
        return new self(
            $state['marque'],
            $state['reference'],
            $state['designation'],
            $state['prix_unitaire'],
            $state['qte_stock'],
            $state['grammage'],
            $state['id_article'],
        );
    }
}
