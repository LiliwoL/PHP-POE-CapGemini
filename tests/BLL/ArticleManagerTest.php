<?php

namespace App\Tests\BLL;

use App\BLL\ArticleManager;
use App\DAL\Mapper\ArticleMapper;
use App\DAL\Mapper\RametteMapper;
use App\DAL\Mapper\StyloMapper;
use App\DAL\Storage\ArticleMySQLStorage;
use App\DAL\Storage\ArticleStorage;
use App\DAL\Storage\Database;
use Dotenv\Dotenv;
use PDO;
use PHPUnit\Framework\TestCase;

class ArticleManagerTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../');
        $dotenv->load();
    }

    private ArticleManager $articleManager;

    public function setUp(): void
    {
        $articleMySQLStorage = new ArticleMySQLStorage();
        // Initialisation d'un DataMapper avec Storage sur MySQL
        $this->articleManager = new ArticleManager(
            new StyloMapper(
                $articleMySQLStorage
            ),
            new RametteMapper(
                $articleMySQLStorage
            ),
            new ArticleMapper(
                $articleMySQLStorage
            )
        );

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
            ':type' => ArticleStorage::TYPE_STYLO
        ]);

        $sth->execute([
            ':marque' => "Clairef",
            ':reference' => "CRA4S",
            ':designation' => "Ramette A4 Sup",
            ':prix_unitaire' => 9,
            ':qte_stock' => 10,
            ':couleur' => null,
            ':grammage' => 80,
            ':type' => ArticleStorage::TYPE_RAMETTE
        ]);

        $sth->execute([
            ':marque' => "Bic",
            ':reference' => "BBVert",
            ':designation' => "Bic bille Vert",
            ':prix_unitaire' => 1.2,
            ':qte_stock' => 40,
            ':couleur' => "Vert",
            ':grammage' => null,
            ':type' => ArticleStorage::TYPE_STYLO
        ]);

        $sth->execute([
            ':marque' => "Clairef",
            ':reference' => "CD4S",
            ':designation' => "Ramette Plume",
            ':prix_unitaire' => 8.52,
            ':qte_stock' => 30,
            ':couleur' => null,
            ':grammage' => 80,
            ':type' => ArticleStorage::TYPE_RAMETTE
        ]);
    }

    public function testJePeuxCreerUnStylo()
    {
        $this->articleManager->creerStylo('Bic', 'BBViolet', 'Bic bille Violet', 1.3, 50, 'Violet');

        $dbh = Database::getInstance()->getDbh();

        $sth = $dbh->prepare('
            SELECT * FROM articles WHERE reference = \'BBViolet\'
        ');

        $sth->execute();
        $article = $sth->fetch(PDO::FETCH_ASSOC);
        $this->assertEquals('Bic', $article['marque']);
        $this->assertEquals('BBViolet', $article['reference']);
        $this->assertEquals('Bic bille Violet', $article['designation']);
        $this->assertEquals(1.3, $article['prix_unitaire']);
        $this->assertEquals(50, $article['qte_stock']);
        $this->assertEquals('Violet', $article['couleur']);
    }

    public function testJePeuxCreerUneRamette()
    {
        $this->articleManager->creerRamette('Clairef', 'CD5S', 'Ramette Haute Gamme', 30, 50, 60);


        $dbh = Database::getInstance()->getDbh();

        $sth = $dbh->prepare('
            SELECT * FROM articles WHERE reference = \'CD5S\'
        ');

        $sth->execute();
        $article = $sth->fetch(PDO::FETCH_ASSOC);
        $this->assertEquals('Clairef', $article['marque']);
        $this->assertEquals('CD5S', $article['reference']);
        $this->assertEquals('Ramette Haute Gamme', $article['designation']);
        $this->assertEquals(30, $article['prix_unitaire']);
        $this->assertEquals(50, $article['qte_stock']);
        $this->assertEquals(60, $article['grammage']);
    }

    public function testJePeuxSupprimerUnArticle()
    {
        $this->articleManager->supprimerArticle(1);

        $dbh = Database::getInstance()->getDbh();

        $sth = $dbh->prepare('
            SELECT * FROM articles WHERE id_article = 1
        ');

        $sth->execute();
        $article = $sth->fetch(PDO::FETCH_ASSOC);
        $this->assertFalse($article);
    }

    public function testJePeuxDecrementerLaQuantiteEnStockDUnArticle()
    {
        $this->articleManager->decrementerStock(1);
        $dbh = Database::getInstance()->getDbh();

        $sth = $dbh->prepare('
            SELECT * FROM articles WHERE id_article = 1
        ');

        $sth->execute();
        $article = $sth->fetch(PDO::FETCH_ASSOC);
        $this->assertEquals(19, $article['qte_stock']);
    }

    public function testJePeuxRecupererTousLesArticles()
    {
        $articles = $this->articleManager->recupererTousLesArticles();
        $this->assertCount(4, $articles);
        $this->assertEquals('BBOrange', $articles[0]->getReference());
    }

    public function testJePeuxRecupererTousLesStylos()
    {
        $articles = $this->articleManager->recupererTousLesStylos();
        $this->assertCount(2, $articles);
        $this->assertEquals('BBOrange', $articles[0]->getReference());
    }

    public function testJePeuxRecupererToutesLesRamettes()
    {
        $articles = $this->articleManager->recupererToutesLesRamettes();
        $this->assertCount(2, $articles);
        $this->assertEquals('CRA4S', $articles[0]->getReference());
    }
}