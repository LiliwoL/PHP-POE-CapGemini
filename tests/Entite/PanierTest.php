<?php

namespace App\Tests\Entite;

use App\Entite\Collection;
use App\Entite\Ligne;
use App\Entite\Panier;
use App\Entite\Ramette;
use App\Entite\Stylo;
use PHPUnit\Framework\TestCase;

class PanierTest extends TestCase
{
    private Collection $articles;

    // Méthode appelée au lancement de ce test
    public function setUp(): void
    {
        $this->articles = new Collection();
        $unBic = new Stylo("Bic", "BBOrange", "Bic bille Orange", 1.2, 20, "Bleu");
        $uneRamette = new Ramette("Clairef", "CRA4S", "Ramette A4 Sup", 9, 20, 80);
        
        $this->articles->append($unBic);
        $this->articles->append($uneRamette);
        
        $this->articles->append(new Stylo("Stypen", "PlumeS", "Stylo Plume Stypen", 5.5, 20, "jaune"));
        $this->articles->append(new Stylo("Waterman", "WOBGreen", "Waterman Orion Bille vert", 5.5, 20, "vert"));
        $this->articles->append(new Stylo("Parker", "PlumeP", "Stylo Plume Parker", 5.5, 5, "noir"));
    }

    /**
     * Méthode pour vérifier le montant du panier
     * @covers Panier::addLigne
     */
    public function testJePeuxAjouterUneLigneAMonPanier()
    {
        $panier = new Panier();
        $ligne = new Ligne($this->articles->offsetGet(1), 2);
        $panier->addLigne($ligne);

        $montant = 0;
        foreach($panier->getLignes() as $ligne) 
        {
            $montant += $ligne->getArticle()->getPrixUnitaire()*$ligne->getQte();
        }

        $panier->setMontant($montant);

        $this->assertEquals(18, $panier->getMontant());
    }

    public function testJePeuxAjouterPlusieursLignesAMonPanier()
    {
        $panier = new Panier();

        // Ajout de 4 stylo à 1.20€ pièce puis
        $ligne = new Ligne($this->articles->offsetGet(0), 4);
        $panier->addLigne($ligne);

        // Ajout de 2 ramettes à 9€ pièce
        $ligne = new Ligne($this->articles->offsetGet(1), 2);
        $panier->addLigne($ligne);

        $montant = 0;
        foreach($panier->getLignes() as $ligne) 
        {
            $montant += $ligne->getArticle()->getPrixUnitaire()*$ligne->getQte();
        }

        $panier->setMontant($montant);

        $this->assertEquals(22.8, $panier->getMontant());
    }

    public function testJePeuxRetirerUnArticleDeMonPanier()
    {
        $panier = new Panier();

        // Ajout de 4 stylo à 1.20€ pièce puis
        $ligne1 = new Ligne($this->articles->offsetGet(0), 4);
        $panier->addLigne($ligne1);

        // Ajout de 2 ramettes à 9€ pièce
        $ligne2 = new Ligne($this->articles->offsetGet(1), 2);
        $panier->addLigne($ligne2);

        $panier->removeLigne($ligne1);

        $montant = 0;
        foreach($panier->getLignes() as $ligne) 
        {
            $montant += $ligne->getArticle()->getPrixUnitaire()*$ligne->getQte();
        }

        $panier->setMontant($montant);

        $this->assertEquals(18, $panier->getMontant());
    }

    public function testJePeuxModifierLaQuantiteDUnArticleDeMonPanier()
    {
        $panier = new Panier();

        // Ajout de 4 stylo à 1.20€ pièce puis
        $ligne1 = new Ligne($this->articles->offsetGet(0), 4);
        $panier->addLigne($ligne1);

        // Ajout de 2 ramettes à 9€ pièce
        $ligne2 = new Ligne($this->articles->offsetGet(1), 2);
        $panier->addLigne($ligne2);

        $montant = 0;
        foreach($panier->getLignes() as $ligne) 
        {
            $montant += $ligne->getArticle()->getPrixUnitaire()*$ligne->getQte();
        }

        $panier->setMontant($montant);

        $this->assertEquals(22.8, $panier->getMontant());

        $ligneStylo = $panier->getLignes()->offsetGet(0);
        $ligneStylo->setQte($ligneStylo->getQte() + 1);

        $montant = 0;
        foreach($panier->getLignes() as $ligne) 
        {
            $montant += $ligne->getArticle()->getPrixUnitaire()*$ligne->getQte();
        }

        $panier->setMontant($montant);

        $this->assertEquals(24, $panier->getMontant());
    }
}