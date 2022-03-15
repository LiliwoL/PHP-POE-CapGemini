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

    public function testJePeuxMeConnecterAMaBaseDeDonneesMySQL()
    {
        $database = Database::getInstance();
        $this->assertInstanceOf(PDO::class, $database->getDbh());
    }
}