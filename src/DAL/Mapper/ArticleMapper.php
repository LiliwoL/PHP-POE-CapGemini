<?php

namespace App\DAL\Mapper;

// L'interface uniquement, pas besoin de MySQL ou InMemory
use App\DAL\Storage\ArticleStorage;

use App\Entite\Article;
use App\Entite\Collection;
use App\Entite\Ramette;
use App\Entite\Stylo;

class ArticleMapper
{
    // Constructeur qui fait également la déclaration de l'attribut $adapter
    public function __construct( private ArticleStorage $adapter ){}

    public function findAllOrderByQteStockAsc(): Collection
    {
        $result = $this->adapter->findAll('qte_stock');

        $collection = new Collection();

        foreach ($result as $item) {
            $collection->append($this->mapRowToArticle($item));
        }

        return $collection;
    }

    /**
     * Méthode de transformation d'un tableau en entité Article (Stylo ou Ramette)
     * 
     * Attention, le diagramme de classe  TP3 demande un autre nom de méthode mapRowToStylo qui
     * n'est pas très adapté ici
     *
     * @param array $row Un tableau à transformer
     * @return Article
     */
    private function mapRowToArticle( array $row ): Article
    {
        // Test du type pour savoir quel type d'entité renvoyer
        if ($row['type'] === ArticleStorage::TYPE_STYLO)
        {
            // Transformation du tableau en entité Stylo
            return Stylo::fromState($row);
        }

        // Transformation du tableau en entité RAMETTE
        return Ramette::fromState($row);
    }
}