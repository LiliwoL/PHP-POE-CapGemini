<?php

namespace App\DAL\Storage;

use InvalidArgumentException;
use PDO;

class StagiaireMySQLStorage implements StagiaireStorage
{
    private PDO $dbh;

    public function __construct()
    {
        $this->dbh = Database::getInstance()->getDbh();
    }

    public function insert(string $nom): int
    {
        $sth = $this->dbh->prepare('
            INSERT INTO stagiaires 
            (nom)
            VALUES (:nom)
        ');

        $sth->execute([
            ':nom' => $nom
        ]);

        // LastInsertId renvoie une string ou false
        // https://www.php.net/manual/fr/pdo.lastinsertid.php
        // Or, nous on veut un entier!
        return (int)$this->dbh->lastInsertId();
    }

    public function find(int $id): ?array
    {
        $sth = $this->dbh->prepare('
            SELECT * 
            FROM stagiaires 
            WHERE identifiant  = :id
        ');
        $sth->execute([':id' => $id]);
        
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }
        return $result;
    }

    public function findAll(): array
    {
        $sth = $this->dbh->prepare("
            SELECT * 
            FROM stagiaires 
        ");
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(string $nom, int $id)
    {
        $sth = $this->dbh->prepare('
            UPDATE stagiaires
            SET nom = :nom           
            WHERE identifiant = :id
        ');

        $sth->execute([
            ':nom' => $nom,
            ':id' => $id
        ]);
    }

    public function delete(int $id): int
    {
        $sth = $this->dbh->prepare('
            DELETE FROM stagiaires
            WHERE identifiant = :id
        ');

        // la méthode execute renvoie un boolean
        // https://www.php.net/manual/fr/pdostatement.execute.php
        return (int) $sth->execute([
            ':id' => $id
        ]);
    }   
}