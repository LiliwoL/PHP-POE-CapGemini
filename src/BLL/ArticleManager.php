<?php

namespace App\BLL;

use App\DAL\Mapper\ArticleMapper;
use App\DAL\Mapper\RametteMapper;
use App\DAL\Mapper\StyloMapper;
use App\Entite\Ramette;
use App\Entite\Stylo;

class ArticleManager
{
    public function __construct(
        private StyloMapper $styloMapper,
        private RametteMapper $rametteMapper,
        private ArticleMapper $articleMapper
    )
    {
    }

    public function creerStylo(
        string $marque,
        string $reference,
        string $designation,
        float $prixUnitaire,
        int $qteStock,
        string $couleur)
    {
        $stylo = new Stylo($marque, $reference, $designation, $prixUnitaire, $qteStock, $couleur);
        $this->styloMapper->insert($stylo);
    }

    public function creerRamette(
        string $marque,
        string $reference,
        string $designation,
        float $prixUnitaire,
        int $qteStock,
        int $grammage)
    {
        $ramette = new Ramette($marque, $reference, $designation, $prixUnitaire, $qteStock, $grammage);
        $this->rametteMapper->insert($ramette);
    }

    /**
     * Undocumented function
     *
     * @param string $id Bizarre qu'on attende une string pour un id
     * @return void
     * @todo Vérifier le cast du param string vers int
     */
    public function supprimerArticle(string $id)
    {
        // On devrait peut être caster $id en int
        $this->articleMapper->delete($id);
    }

    /**
     * Undocumented function
     *
     * @param string $id Bizarre qu'on attende une string pour un id
     * @return void
     * @todo Vérifier le cast du param string vers int
     */
    public function decrementerStock(string $id)
    {
        $article = $this->articleMapper->findById($id);
        $article->setQteStock($article->getQteStock() - 1);
        
        if ($article instanceof Stylo) {
            $this->styloMapper->update($article);
        } else {
            $this->rametteMapper->update($article);
        }
    }

    public function recupererTousLesStylos()
    {
        return $this->styloMapper->findAll();
    }

    public function recupererTousLesArticles()
    {
        return $this->articleMapper->findAll();
    }

    public function recupererToutesLesRamettes()
    {
        return $this->rametteMapper->findAll();
    }
}