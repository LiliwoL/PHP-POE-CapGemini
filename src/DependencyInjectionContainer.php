<?php

namespace App;

use App\DAL\Storage\StagiaireInMemoryStorage;
use App\DAL\Storage\StagiaireMySQLStorage;
use App\DAL\Storage\StagiaireStorage;
use App\DAL\Mapper\StagiaireMapper;
use LogicException;

class DependencyInjectionContainer
{
    private static ?DependencyInjectionContainer $instance = null;
    private array $instances = [];


    private function __construct()
    {
        if ($_ENV['DATABASE_DRIVER'] === 'mysql') 
        {
            $stagiaireMapper = new StagiaireMapper(
                new StagiaireMySQLStorage()
            );
        } else {
            $stagiaireMapper = new StagiaireMapper(                
                new StagiaireInMemoryStorage()
            );
        }

        // Liste des dépendances disponibles
        $this->instances = [
            StagiaireMapper::class => $stagiaireMapper
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
