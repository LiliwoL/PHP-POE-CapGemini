<?php

namespace App\Tests\DAL\Mapper;

use App\DAL\Mapper\ArticleMapper;
use App\DAL\Storage\ArticleMySQLStorage;
use App\DAL\Storage\ArticleStorage;
use App\DAL\Storage\Database;
use App\Entite\Ramette;
use App\Entite\Stylo;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class ArticleMapperTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
        $dotenv->load(); 
    }

    private ArticleMapper $articleMapper;
    public function setUp(): void
    {
        // Initialisation d'un DataMapper avec Storage sur MySQL
        $this->articleMapper = new ArticleMapper(
            new ArticleMySQLStorage()
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

    public function testJePeuxRecupererTousLesArticlesTriesParQuantiteEnStock()
    {
        $articles = $this->articleMapper->findAllOrderByQteStockAsc();

        $this->assertCount(4, $articles);

        $this->assertInstanceOf(Ramette::class, $articles[0]);
        $this->assertEquals(10, $articles[0]->getQteStock());

        $this->assertInstanceOf(Stylo::class, $articles[1]);
        $this->assertEquals(20, $articles[1]->getQteStock());

        $this->assertInstanceOf(Ramette::class, $articles[2]);
        $this->assertEquals(30, $articles[2]->getQteStock());

        $this->assertInstanceOf(Stylo::class, $articles[3]);
        $this->assertEquals(40, $articles[3]->getQteStock());

    }
}