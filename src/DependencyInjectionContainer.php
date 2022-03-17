<?php

namespace App;

use LogicException;
use App\BLL\ArticleManager;
use App\BLL\StagiaireManager;
use App\DAL\Mapper\StyloMapper;
use App\DAL\Mapper\ArticleMapper;

use App\DAL\Mapper\RametteMapper;
use App\DAL\Mapper\StagiaireMapper;
use App\DAL\Storage\StagiaireStorage;

use App\DAL\Storage\ArticleMySQLStorage;
use App\DAL\Storage\StagiaireMySQLStorage;
use App\DAL\Storage\StagiaireInMemoryStorage;

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

        // Dépendances pour le RametteMapper
        $rametteMapper = new RametteMapper(
            new ArticleMySQLStorage()
        );

        // Dépendances pour le ArticleMapper
         $articleMapper = new ArticleMapper(
            new ArticleMySQLStorage()
        );

        // On va "encapsuler tous ces mappers au sein du manager
        $articleManager = new ArticleManager($styloMapper, $rametteMapper, $articleMapper);

        // Liste des dépendances disponibles
        $this->instances = [
            StagiaireManager::class => $stagiaireManager,
            
            ArticleManager::class => $articleManager,

            // On garde ces lignes pour la rétro compatibilité, mais elles ne sont plus utiles!
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
