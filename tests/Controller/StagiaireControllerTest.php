<?php

namespace App\Tests\Controller;

use App\BLL\StagiaireManager;
use App\Controller\StagiaireController;
use App\DAL\Mapper\StagiaireMapper;
use App\DAL\Storage\Database;
use App\DAL\Storage\StagiaireInMemoryStorage;
use App\DAL\Storage\StagiaireMySQLStorage;
use App\Http\Request;
use App\Http\Response;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use function Patchwork\redefine;
use function Patchwork\restoreAll;

class StagiaireControllerTest extends TestCase
{
    private StagiaireManager $stagiaireManagerInMemory;
    private StagiaireManager $stagiaireManagerMySQL;

    public function setUp(): void
    {
        define('__ROOT__', dirname(__DIR__).'/../');
        // Chargement de Twig
        $loader = new \Twig\Loader\FilesystemLoader( __ROOT__ . 'templates');
        define(
            '__TWIG__',
            new \Twig\Environment(
                $loader, 
                [
                    // En fonction du .env, on peut activer ou non le cache
                    'cache' => false

                    // Activation dans le dossier var
                    //'cache' => __ROOT__ . 'var/compilation_cache',
                ]
            )
        );

        // Initialisation d'un DataMapper avec Storage In Memory
        $this->stagiaireManagerInMemory = new StagiaireManager(
            new StagiaireMapper(
                new StagiaireInMemoryStorage([[
                    'identifiant' => 1,
                    'nom' => "Bob",
                    'ddn' => '2000-10-10',
                ]])
            )
        );

        // Initialisation d'un DataMapper avec Storage sur MySQL
        $this->stagiaireManagerMySQL = new StagiaireManager(
            new StagiaireMapper(
                new StagiaireMySQLStorage()
            )
        );

        // Chargement de fixtures
        $dbh = Database::getInstance()->getDbh();
        $dbh->query('TRUNCATE TABLE stagiaires');

        $sth = $dbh->prepare('
            INSERT INTO stagiaires (nom, ddn)
            VALUES (:nom, :ddn)
        ');

        $sth->execute([
            ':nom' => "Bob",
            ':ddn' => '2000-10-10',
        ]);
    }

    public static function setUpBeforeClass(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../');
        $dotenv->load();

        redefine('header', function (string $header, bool $replace = true, int $response_code = 0) {
            return $header;
        });
    }

    public static function tearDownAfterClass(): void
    {
        restoreAll();
    }

    public function testJePeuxListerLesStagiairesSurLeStorageInMemory()
    {
        $controller = new StagiaireController($this->stagiaireManagerInMemory);
        $response = $controller->listView(new Request([]));
        $this->assertInstanceOf(Response::class, $response);
        ob_start();
        $response();
        $response = ob_get_contents();
        ob_clean();
        ob_end_flush();

        $table = <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Mes Stagiaires</title>
</head>
<body class="container">
    
<h1>La liste des stagiaires</h1>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nom</th>
      <th scope="col">Age</th>
    </tr>
  </thead>
  <tbody>
            <tr>
        <th scope="row">1</th>
        <td>Bob</td>
        <td>21</td>
        </tr>
      </tbody>
</table>

<a href="/create" class="btn btn-primary">Créer un nouveau stagiaire</a>

</body>
</html>
HTML;

        $this->assertEquals(
            $table,
            $response
        );
    }


    public function testJePeuxListerLesStagiairesSurLeStorageMySQL()
    {
        $controller = new StagiaireController($this->stagiaireManagerMySQL);
        $response = $controller->listView(new Request([]));
        $this->assertInstanceOf(Response::class, $response);
        ob_start();
        $response();
        $response = ob_get_contents();
        ob_clean();
        ob_end_flush();

        $table = <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Mes Stagiaires</title>
</head>
<body class="container">
    
<h1>La liste des stagiaires</h1>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nom</th>
      <th scope="col">Age</th>
    </tr>
  </thead>
  <tbody>
            <tr>
        <th scope="row">1</th>
        <td>Bob</td>
        <td>21</td>
        </tr>
      </tbody>
</table>

<a href="/create" class="btn btn-primary">Créer un nouveau stagiaire</a>

</body>
</html>
HTML;

        $this->assertEquals(
            $table,
            $response
        );
    }
}
