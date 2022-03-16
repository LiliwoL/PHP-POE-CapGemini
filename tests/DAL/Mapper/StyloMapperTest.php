<?php

namespace App\Tests\DAL\Mapper;

use App\DAL\Mapper\ArticleMapper;
use App\DAL\Mapper\StyloMapper;
use App\DAL\Storage\ArticleMySQLStorage;
use App\DAL\Storage\ArticleStorage;
use App\DAL\Storage\Database;
use App\Entite\Stylo;
use Dotenv\Dotenv;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class StyloMapperTest extends TestCase
{

    private StyloMapper $styloMapper;

    public static function setUpBeforeClass(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
        $dotenv->load(); 
    }

    public function setUp(): void
    {
        // Initialisation d'un DataMapper avec Storage sur MySQL
        $this->styloMapper = new StyloMapper(
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
    }

    public function testJePeuxCreerUnNouveauStylo()
    {
        $stylo = new Stylo('BIC', 'BBVert', 'Bic bille Vert', 1.4, 30, 'Vert');
        $this->styloMapper->insert($stylo);

        $stylo = $this->styloMapper->findById(2);
        $this->assertIsObject($stylo);
        $this->assertEquals(1.4, $stylo->getPrixUnitaire());
    }

    public function testJePeuxModifierLaQteEnStockDUnStylo()
    {
        $stylo = $this->styloMapper->findById(1);
        $stylo->setQteStock(15);
        $this->styloMapper->update($stylo);

        $stylo = $this->styloMapper->findById(1);
        $this->assertIsObject($stylo);
        $this->assertEquals(15, $stylo->getQteStock());
    }

    public function testJePeuxSupprimerUnStylo()
    {
        $this->styloMapper->delete(1);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User #1 not found');
        $this->styloMapper->findById(1);
    }

    public function testJePeuxRecupererTousLesStylos()
    {
        $stylo = new Stylo('BIC', 'BBVert', 'Bic bille Vert', 1.4, 30, 'Vert');
        $this->styloMapper->insert($stylo);

        $stylos = $this->styloMapper->findAll();

        $this->assertEquals($stylos->offsetGet(0)->getReference(), 'BBOrange');
        $this->assertEquals($stylos->offsetGet(1)->getReference(), 'BBVert');
    }

    public function testJePeuxRecupererUnStyloParSonIdentifiant()
    {
        $stylo = $this->styloMapper->findById(1);
        $this->assertIsObject($stylo);
        $this->assertEquals(1.2, $stylo->getPrixUnitaire());
    }

}