<?php

namespace App\Entite;

use JsonSerializable;
use App\DAL\Storage\ArticleStorage;

class Stylo extends Article implements JsonSerializable
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

    /**
     * Transformation d'un tableau en entité Stylo
     * 
     * @param $state Tableau associatif correspondant à un Stylo
     * @return Stylo Renvoi une entité Stylo
     */
    public static function fromState(array $state): Stylo
    {
        // On devrait vérifier le contenu de $state !!
        
        return new self(
            $state['marque'],
            $state['reference'],
            $state['designation'],
            $state['prix_unitaire'],
            $state['qte_stock'],
            $state['couleur'],
            $state['id_article'],
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'marque' => $this->getMarque(),
            'reference' => $this->getReference(),
            'designation' => $this->getDesignation(),
            'prix_unitaire' => $this->getPrixUnitaire(),
            'qte_stock' => $this->getQteStock(),
            'couleur' => $this->couleur,
            'type' => ArticleStorage::TYPE_STYLO
        ];
    }
}