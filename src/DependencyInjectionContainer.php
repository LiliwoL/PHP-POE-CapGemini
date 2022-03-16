<?php

namespace App;

use App\BLL\StagiaireManager;
use App\DAL\Storage\StagiaireInMemoryStorage;
use App\DAL\Storage\StagiaireMySQLStorage;
use App\DAL\Storage\StagiaireStorage;
use App\DAL\Mapper\StagiaireMapper;

use App\DAL\Mapper\ArticleMapper;
use App\DAL\Mapper\StyloMapper;
use App\DAL\Storage\ArticleMySQLStorage;

use LogicException;

class DependencyInjectionContainer
{
    private static ?DependencyInjectionContainer $instance = null;
    private array $instances = [];


    private function __construct()
    {
        // Dépendance pour le StagiaireMapper
        if ($_ENV['DATABASE_DRIVER'] === 'mysql') 
        {
            $stagiaireManager = new StagiaireManager(
                new StagiaireMapper(
                    new StagiaireMySQLStorage()
                )
            );
        } else {
            $stagiaireManager = new StagiaireManager(
                new StagiaireMapper(       
                    new StagiaireInMemoryStorage()
                )
            );
        }

        // Dépendances pour le StyloMapper
        $styloMapper = new StyloMapper(
            new ArticleMySQLStorage()
        );

        // Dépendances pour le ArticleMapper
         $articleMapper = new ArticleMapper(
            new ArticleMySQLStorage()
        );

        // Liste des dépendances disponibles
        $this->instances = [
            StagiaireManager::class => $stagiaireManager,

            StyloMapper::class => $styloMapper,
            ArticleMapper::class => $articleMapper,
        ];
    }

    // Singleton
    public static function getInstance(): DependencyInjectionContainer
    {
        if (self::$instance === null) {
            self::$instance = new DependencyInjectionContainer();
        }
        return self::$instance;
    }

    // Méthode pour aller chercher nos dépendances (dans un tableau)
    public function get(string $class)
    {
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }
        throw new LogicException("Le service $class n\'existe pas");
    }

    // Méthode pour affichage la liste de toutes les déps
    public function listDependencies(){
        var_dump($this->instances);
    }
}
