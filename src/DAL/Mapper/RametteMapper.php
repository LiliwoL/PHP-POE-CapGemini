<?php

namespace App\DAL\Mapper;

use App\Entite\Ramette;
use App\Entite\Collection;
use InvalidArgumentException;
use App\DAL\Storage\ArticleStorage;

class RametteMapper
{
    /**
     * Le constructeur a besoin d'un ArticleStorage
     *
     * @param ArticleStorage $adapter
     */
    public function __construct( private ArticleStorage $adapter ){}

    /**
     * Méthode pour persister en base
     *
     * @param Ramette $Ramette
     * @return integer
     */
    public function insert(Ramette $ramette): int
    {
        return $this->adapter->insert(
            $ramette->getMarque(),
            $ramette->getReference(),
            $ramette->getDesignation(),
            $ramette->getPrixUnitaire(),
            $ramette->getQteStock(),
            ArticleStorage::TYPE_RAMETTE,
            null,
            $ramette->getGrammage()
        );
    }

    /**
     * Find a Ramette By Id
     *
     * @param integer $id
     * @return Ramette
     */
    public function findById(int $id): Ramette
    {
        $result = $this->adapter->find($id);

        if ($result === null) {
            throw new InvalidArgumentException("User #$id not found");
        }

        // Appel à la méthode pour transformer une ligne en Ramette
        return $this->mapRowToRamette($result);
    }

    /**
     * Undocumented function
     *
     * @param Ramette $ramette
     * @return void
     */
    public function update(Ramette $ramette)
    {
        $this->adapter->update(
            $ramette->getIdArticle(),
            $ramette->getMarque(),
            $ramette->getReference(),
            $ramette->getDesignation(),
            $ramette->getPrixUnitaire(),
            $ramette->getQteStock(),
            null,
            $ramette->getGrammage()
        );
    }

    /**
     * Renvoi d'un tableau d'objets Ramette
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        // La méthode findAll renvoie un tableau de tableau
        $result = $this->adapter->findAllByType(ArticleStorage::TYPE_RAMETTE);

        // On veut un tableau d'objets
        $collection = new Collection();

        // On doit renvoyer un tableau d'objets Ramette
        foreach ($result as $item) {

            $collection->append( 
                // Transformation du tableau $item en entité Stylo
                $this->mapRowToRamette($item) 
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
     * Méthode de transformation d'un tableau en Ramette 
     *
     * @param array $row Le tableau doit contenir ça et ça
     * @return Ramette
     */
    private function mapRowToRamette(array $row): Ramette
    {
        // Appel de la méthode statique de l'entité Ramette
        return Ramette::fromState($row);
    }
}