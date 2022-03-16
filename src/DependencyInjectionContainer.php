<?php

namespace App;

use App\DAL\Storage\StagiaireInMemoryStorage;
use App\DAL\Storage\StagiaireMySQLStorage;
use App\DAL\Storage\StagiaireStorage;
use LogicException;

class DependencyInjectionContainer
{
    private static ?DependencyInjectionContainer $instance = null;
    private array $instances = [];


    private function __construct()
    {
        if ($_ENV['DATABASE_DRIVER'] === 'mysql') {
            $stagiaireStorage = new StagiaireMySQLStorage();
        } else {
            $stagiaireStorage = new StagiaireInMemoryStorage([]);
        }

        // Liste des dépendances disponibles
        $this->instances = [
            StagiaireStorage::class => $stagiaireStorage
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
        throw new LogicException('Le service %s n\'existe pas', $class);
    }

    public function listDependencies(){
        var_dump($this->instances);
    }
}
