<?php

namespace App\Tests\DAL\Storage;

use App\DAL\Storage\Database;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;
use PDO;

class DatabaseTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
        $dotenv->load(); 
    }

    /**
     * Test de \DAL\Storage\Database
     * 
     * @covers \DAL\Storage\Database::__construct
     * @covers \DAL\Storage\Database::getInstance
     * @covers \DAL\Storage\Database::getDbh
     */
    public function testJePeuxMeConnecterAMaBaseDeDonneesMySQL()
    {
        $database = Database::getInstance();
        $this->assertInstanceOf(PDO::class, $database->getDbh());
    }
}