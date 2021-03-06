<?php

namespace App\DAL\Storage;

use PDO;
use PDOException;

class Database{

    // Attributs
    private static ?Database $instance = null;
    private $dbh;

    // Constructeur
    private function __construct()
    {
        // Tester la connexion à la base
        try {
            // https://www.php.net/manual/fr/class.pdo.php
            $this->dbh = new PDO(
                /*
                    Sans dotEnv:
                    "mysql:host=db;port=3306;dbname=formation",
                    "admin",
                    "admin123"
                */

                // Avec dotenv:
                $_ENV['DATABASE_DSN'],
                $_ENV['DATABASE_USERNAME'],
                $_ENV['DATABASE_PASSWORD']
            );

            // Définition du mode d'erreur de PDO en Exception
            // https://www.php.net/manual/fr/pdo.error-handling.php
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch ( PDOException $e ){
            echo $e->getMessage();
            die;
        }
    }

    public static function getInstance(): Database
    {
        // Test si une instance existe déjà
        if (self::$instance === null){
            self::$instance = new Database();
        }

        return self::$instance;

        /*
         On pourrait simplifier en une ligne
         return self::$instance ?? new Database();
        */
    }

    // Getter pour le DB Handler
    public function getDbh()
    {
        return $this->dbh;
    }
}