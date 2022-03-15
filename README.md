# TP 1

## Enoncé

On demande ici de créer les entités correspondantes au diagramme de classe fourni.

***

## Initialisation de composer

```bash
composer init
```


### Utilisation de composer pour l'autoloading

Dans les projets en PHP, nous avons souvent besoin d’un système d’autoloading.

Au lieu de créer de zéro ce système d’autoloading en PHP, il suffit d’initialiser composer et de l’utiliser simplement.

#### Autoloading et namespace

On modifie la ligne
    
    "autoload": {
        "psr-4": {
            /* On modifie ceci pour notre autoload */
            "Eni\\Tp1\\": "src/"
        }
    
par

    "autoload": {
        "psr-4": {            
            "App\\": "src/"
        }
    },

#### Fichier principal du projet

Le fichier principal du projet **index.php** contiendra:

    <?php
    require dirname(__DIR__).'/vendor/autoload.php';

#### Namespace

Dans les classes du dossier **src/**, on pourra définir le namespace avec:

    <?php
    namespace App\Entite;


#### Dump de l'autoload

Dans le cas où l'autoload e composer n'est pas correct, vous pouvez faire un **dump**:

    composer dump

***

## PhpUnit


On va utiliser PhpUnit pour faire les tests

### Installation

    composer require phpunit/phpunit --dev

La dépendance est installée en mode **dev**


### Ecriture du code

Dans le dossier **<root>/tests/Entite**, créez le fichier **PanietTest.php**

```php
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

    // Méthode pour vérifier le montant du panier
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
```

### Lancement des tests

Avec la commande suivante, les tests placés dans le fichier précédent vont être lancés:

    $ php vendor/bin/phpunit ./tests/Entite/PanierTest.php
    PHPUnit 9.5.18 #StandWithUkraine

    ....                                                                4 / 4 (100%)

    Time: 00:00.018, Memory: 4.00 MB

    OK (4 tests, 5 assertions)


### Génération d'une configuration de phpunit

Afin de faire des tests de couverture, il faudra:

* Avoir XDebug  installé et configuré
* Configuration de PHPUnit

```bash
php vendor/bin/phpunit --generate-configuration
```

### Couverture de code

```bash
php vendor/bin/phpunit --coverage-html out/ tests/
```
On pourra trouver les rapports dans le sossier **out/**

***


## Qualité du code

On va utiliser **PhpCodeSniffer**

### Installation

    composer require squizlabs/php_codesniffer --dev

### Utilisation

    php vendor/bin/phpcs src