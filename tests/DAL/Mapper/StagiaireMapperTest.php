<?php

use App\DAL\Mapper\StagiaireMapper;
use App\DAL\Storage\Database;
use App\DAL\Storage\StagiaireInMemoryStorage;
use App\DAL\Storage\StagiaireMySQLStorage;
use App\Entite\Stagiaire;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class StagiaireMapperTest extends TestCase
{
    private StagiaireMapper $stagiaireMapperInMemory;
    private StagiaireMapper $stagiaireMapperMySQL;

    public static function setUpBeforeClass(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
        $dotenv->load();
    }

    public function setUp(): void
    {
        // Initialisation d'un DataMapper avec Storage In Memory
        $this->stagiaireMapperInMemory = new StagiaireMapper(
            new StagiaireInMemoryStorage([[
                'identifiant' => 1,
                'nom' => "Bob",
            ]])
        );

        // Initialisation d'un DataMapper avec Storage sur MySQL
        $this->stagiaireMapperMySQL = new StagiaireMapper(
            new StagiaireMySQLStorage()
        );

        // Chargement de fixtures
        $dbh = Database::getInstance()->getDbh();
        $dbh->query('TRUNCATE TABLE stagiaires');

        $sth = $dbh->prepare('
            INSERT INTO stagiaires (nom)
            VALUES (:nom)
        ');

        $sth->execute([
            ':nom' => "Bob",
        ]);
    }

    public function testJePeuxListerLesStagiairesSurLeStorageInMemory()
    {
        $stagiaires = $this->stagiaireMapperInMemory->findAll();

        $this->assertCount(1, $stagiaires);
        $this->assertEquals('Bob', $stagiaires[0]->getNom());
    }

    public function testJeCreerUnStagiaireSurLeStorageInMemory()
    {
        $stagiaire = new Stagiaire('John');
        $this->stagiaireMapperInMemory->insert($stagiaire);

        $stagiaires = $this->stagiaireMapperInMemory->findAll();
        $this->assertCount(2, $stagiaires);
        $this->assertEquals('John', $stagiaires[1]->getNom());
    }

    public function testJePeuxListerLesStagiairesSurLeStorageMySQL()
    {
        $stagiaires = $this->stagiaireMapperMySQL->findAll();

        $this->assertCount(1, $stagiaires);
        $this->assertEquals('Bob', $stagiaires[0]->getNom());
    }

    public function testJeCreerUnStagiaireSurLeStorageMySQL()
    {
        $stagiaire = new Stagiaire('John');
        $this->stagiaireMapperMySQL->insert($stagiaire);

        $stagiaires = $this->stagiaireMapperMySQL->findAll();
        $this->assertCount(2, $stagiaires);
        $this->assertEquals('John', $stagiaires[1]->getNom());
    }
}