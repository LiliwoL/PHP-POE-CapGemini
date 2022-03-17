<?php

namespace App\DAL\Mapper;

// L'interface uniquement, pas besoin de MySQL ou InMemory
use App\DAL\Storage\ArticleStorage;
use InvalidArgumentException;


use App\Entite\Article;
use App\Entite\Collection;
use App\Entite\Ramette;
use App\Entite\Stylo;

class ArticleMapper
{
    // Constructeur qui fait également la déclaration de l'attribut $adapter
    public function __construct( private ArticleStorage $adapter ){}

    public function findById(int $id): Article
    {
        $result = $this->adapter->find($id);

        if ($result === null) {
            throw new InvalidArgumentException("Article #$id not found");
        }

        return $this->mapRowToArticle($result);
    }

    public function findAllOrderByQteStockAsc(): Collection
    {
        $result = $this->adapter->findAll('qte_stock');

        $collection = new Collection();

        foreach ($result as $item) {
            $collection->append($this->mapRowToArticle($item));
        }

        return $collection;
    }

    public function findAll(): Collection
    {
        $result = $this->adapter->findAll('id_article');

        $collection = new Collection();
        foreach ($result as $item) {
            $collection->append($this->mapRowToArticle($item));
        }

        return $collection;
    }

    public function delete(int $id)
    {
        $this->adapter->delete($id);
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