<?php

namespace App\Tests\DAL\Storage;

use App\DAL\Storage\ArticleMySQLStorage;
use App\DAL\Storage\Database;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class ArticleMySQLStorageTest extends TestCase
{
    private ArticleMySQLStorage $articleMySQLStorage;

    public static function setUpBeforeClass(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
        $dotenv->load(); 
    }
    
    public function setUp(): void 
    {
        // Chargement de fixtures
        $dbh = Database::getInstance()->getDbh();
        $dbh->query('TRUNCATE TABLE articles');
        
        $sth = $dbh->prepare('
            INSERT INTO articles (reference, marque, designation, prix_unitaire, qte_stock, couleur, grammage, type)
            VALUES (:reference, :marque, :designation, :prix_unitaire, :qte_stock, :couleur, :grammage, :type)
        ');

        $sth->execute([
            ':marque' => "Bic",
            ':reference' => "BBOrange",
            ':designation' => "Bic bille Orange",
            ':prix_unitaire' => 1.2,
            ':qte_stock' => 20,
            ':couleur' => "Orange",
            ':grammage' => null,
            ':type' => 'STYLO'
        ]);

        $sth->execute([
            ':marque' => "Clairef",
            ':reference' => "CRA4S",
            ':designation' => "Ramette A4 Sup",
            ':prix_unitaire' => 9,
            ':qte_stock' => 10,
            ':couleur' => null,
            ':grammage' => 80,
            ':type' => 'RAMETTE'
        ]);

        $sth->execute([
            ':marque' => "Bic",
            ':reference' => "BBVert",
            ':designation' => "Bic bille Vert",
            ':prix_unitaire' => 1.2,
            ':qte_stock' => 40,
            ':couleur' => "Vert",
            ':grammage' => null,
            ':type' => 'STYLO'
        ]);

        $sth->execute([
            ':marque' => "Clairef",
            ':reference' => "CD4S",
            ':designation' => "Ramette Plume",
            ':prix_unitaire' => 8.52,
            ':qte_stock' => 30,
            ':couleur' => null,
            ':grammage' => 80,
            ':type' => 'RAMETTE'
        ]);

        $this->articleMySQLStorage = new ArticleMySQLStorage();
    }

    public function testJePeuxRecupererUnArticleParSonIdentifiant()
    {
        $article = $this->articleMySQLStorage->find(1);
        $this->assertEquals('Bic', $article['marque']);
        $this->assertEquals('BBOrange', $article['reference']);
        $this->assertEquals('Bic bille Orange', $article['designation']);
        $this->assertEquals(1.2, $article['prix_unitaire']);
        $this->assertEquals(20, $article['qte_stock']);
        $this->assertEquals('Orange', $article['couleur']);
        $this->assertEquals('', $article['grammage']);
        $this->assertEquals('STYLO', $article['type']);
    }

    public function testJePeuxRecupererTousLesArticleTriesParPrix()
    {
        $articles = $this->articleMySQLStorage->findAll('prix_unitaire', 'ASC');;
        
        $this->assertEquals(1.2, $articles[0]['prix_unitaire']);
        $this->assertEquals(1.2, $articles[1]['prix_unitaire']);
        $this->assertEquals(8.52, $articles[2]['prix_unitaire']);
        $this->assertEquals(9, $articles[3]['prix_unitaire']);
    }

    public function testJePeuxChangerLePrixDUnArticle()
    {
        $this->articleMySQLStorage->update(1, 'Bic', 'BBOrange', 'Bic bille Orange', 1.4, 20, 'Orange');
        $article = $this->articleMySQLStorage->find(1);
        $this->assertEquals(1.4, $article['prix_unitaire']);
    }

    public function testJePeuxAjouterUnArticle()
    {
        $this->articleMySQLStorage->insert('Bic', 'BBBleu', 'Bic bille Bleu', 1.4, 40, 'STYLO', 'Bleu');
        $article = $this->articleMySQLStorage->find(5);
        $this->assertEquals('Bic', $article['marque']);
        $this->assertEquals('BBBleu', $article['reference']);
        $this->assertEquals('Bic bille Bleu', $article['designation']);
        $this->assertEquals(1.4, $article['prix_unitaire']);
        $this->assertEquals(40, $article['qte_stock']);
        $this->assertEquals('Bleu', $article['couleur']);
        $this->assertEquals('', $article['grammage']);
        $this->assertEquals('STYLO', $article['type']);
    }

    public function testJePeuxSupprimerUnArticle()
    {
        $this->articleMySQLStorage->delete(1);
        $article = $this->articleMySQLStorage->find(1);
        $this->assertNull($article);
    }

    public function testJePeuxRecupererLesArticlesParType()
    {
        $stylos = $this->articleMySQLStorage->findAllByType('STYLO');
        $this->assertCount(2, $stylos);
        $this->assertEquals('STYLO', $stylos[0]['type']);
        $this->assertEquals('STYLO', $stylos[1]['type']);
    }
}