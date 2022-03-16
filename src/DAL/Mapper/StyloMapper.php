<?php

namespace App\DAL\Mapper;

use App\DAL\Storage\ArticleStorage;
use App\Entite\Collection;
use App\Entite\Stylo;
use InvalidArgumentException;

/**
 * fait la liaison entre l'entité et le stockage
 */
class StyloMapper
{
    public function __construct( private ArticleStorage $adapter ){}

    /**
     * Méthode pour persister en base
     *
     * @param Stylo $stylo
     * @return integer
     */
    public function insert(Stylo $stylo): int
    {
        return $this->adapter->insert(
            $stylo->getMarque(),
            $stylo->getReference(),
            $stylo->getDesignation(),
            $stylo->getPrixUnitaire(),
            $stylo->getQteStock(),
            ArticleStorage::TYPE_STYLO,
            $stylo->getCouleur()
        );
    }

    /**
     * Find a Stylo By Id
     *
     * @param integer $id
     * @return Stylo
     */
    public function findById(int $id): Stylo
    {
        $result = $this->adapter->find($id);

        if ($result === null) {
            throw new InvalidArgumentException("User #$id not found");
        }

        // Appel à la méthode pour transformer une ligne en Stylo
        return $this->mapRowToStylo($result);
    }
    
    /**
     * Undocumented function
     *
     * @param Stylo $stylo
     * @return void
     */
    public function update(Stylo $stylo)
    {
        $this->adapter->update(
            $stylo->getIdArticle(),
            $stylo->getMarque(),
            $stylo->getReference(),
            $stylo->getDesignation(),
            $stylo->getPrixUnitaire(),
            $stylo->getQteStock(),
            $stylo->getCouleur()
        );
    }

    /**
     * Renvoi d'un tableau d'objets Stylo
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        // La méthode findAll renvoie un tableau de tableau
        $result = $this->adapter->findAllByType(ArticleStorage::TYPE_STYLO);

        // On veut un tableau d'objets
        $collection = new Collection();

        // On doit renvoyer un tableau d'objets Stylo
        foreach ($result as $item) {

            $collection->append( 
                // Transformation du tableau $item en entité Stylo
                $this->mapRowToStylo($item) 
            );
        }

        return $collection;
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {
        $this->adapter->delete($id);
    }

    /**
     * Méthode de transformation d'un tableau en Stylo 
     *
     * @param array $row
     * @return Stylo
     */
    private function mapRowToStylo(array $row): Stylo
    {
        // Appel de la méthode statique de l'entité Stylo
        return Stylo::fromState($row);
    }
}