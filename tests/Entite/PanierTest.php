<?php

namespace App\Tests\Entite;

use App\Entite\Collection;
use App\Entite\Stylo;
use App\Entite\Ramette;

use PHPUnit\Framework\TestCase;

class PanierTest extends TestCase
{
    // Attribut
    private Collection $articles;

    // Premier Test de mise en place d'un panier
    // et l'ajout d'élément sà l'intérieur
    public function testSetUp(): void
    {
        // Instance de Collection
        $this->articles = new Collection();

        // Instance de Stylo
        $unBic = new Stylo("Bic", "BBOrange", "Bic bille Orange", 1.2, 20, "Bleu");

        // Instance de Ramette
        $uneRamette = new Ramette("Clairef", "CRA4S", "Ramette A4 Sup", 9, 20, 80);
        
        $this->articles->append($unBic);
        $this->articles->append($uneRamette);
        
        $this->articles->append(new Stylo("Stypen", "PlumeS", "Stylo Plume Stypen", 5.5, 20, "jaune"));
        $this->articles->append(new Stylo("Waterman", "WOBGreen", "Waterman Orion Bille vert", 5.5, 20, "vert"));
        $this->articles->append(new Stylo("Parker", "PlumeP", "Stylo Plume Parker", 5.5, 5, "noir"));

        // Un vrai test pour vérifier le nombre d'éléments du panier
        $this->assertEquals(count($this->articles), 5);
    }
}