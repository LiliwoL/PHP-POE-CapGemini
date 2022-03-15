<?php

namespace App\DAL\Storage;

use InvalidArgumentException;
use PDO;

class ArticleMySQLStorage
{
    private PDO $dbh;

    public function __construct()
    {
        $this->dbh = Database::getInstance()->getDbh();
    }

    public function find(int $id): ?array
    {
        $sth = $this->dbh->prepare('
            SELECT * 
            FROM articles 
            WHERE id_article = :id
        ');
        $sth->execute([':id' => $id]);
        
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }
        return $result;
    }

    public function insert(string $marque, string $reference, string $designiation, float $prixUnitaire, int $qteStock, string $type, ?string $couleur = null, ?int $grammage = null): int
    {
        $sth = $this->dbh->prepare('
            INSERT INTO articles 
            (reference, marque, designation, prix_unitaire, qte_stock, couleur, grammage, type)
            VALUES (:reference, :marque, :designation, :prix_unitaire, :qte_stock, :couleur, :grammage, :type)
        ');

        $sth->execute([
            ':marque' => $marque,
            ':reference' => $reference,
            ':designation' => $designiation,
            ':prix_unitaire' => $prixUnitaire,
            ':qte_stock' => $qteStock,
            ':couleur' => $couleur,
            ':grammage' => $grammage,
            ':type' => $type,
        ]);

        // LastInsertId renvoie une string ou false
        // https://www.php.net/manual/fr/pdo.lastinsertid.php
        // Or, nous on veut un entier!
        return (int)$this->dbh->lastInsertId();
    }

    public function update(int $id, string $marque, string $reference, string $designiation, float $prixUnitaire, int $qteStock, ?string $couleur = null, ?int $grammage = null)
    {
        $sth = $this->dbh->prepare('
            UPDATE articles
            SET reference = :reference, marque = :marque, designation = :designation,
            prix_unitaire = :prix_unitaire, qte_stock = :qte_stock, couleur = :couleur
            WHERE id_article = :id_article
        ');

        $sth->execute([
            ':marque' => $marque,
            ':reference' => $reference,
            ':designation' => $designiation,
            ':prix_unitaire' => $prixUnitaire,
            ':qte_stock' => $qteStock,
            ':couleur' => $couleur,
            ':id_article' => $id
        ]);
    }

    public function delete(int $id): int
    {
        $sth = $this->dbh->prepare('
            DELETE FROM articles
            WHERE id_article = :id_article
        ');

        // la méthode execute renvoie un boolean
        // https://www.php.net/manual/fr/pdostatement.execute.php
        return (int) $sth->execute([
            ':id_article' => $id
        ]);
    }

    public function findAll(string $sortBy, string $direction = 'ASC'): array
    {
        // On s'assure du champ utilisé pour le tri
        if (!in_array($sortBy, [
            'id_article',
            'reference',
            'marque',
            'designation',
            'prix_unitaire',
            'qte_stock',
            'grammage',
            'couleur',
            'type'
        ], true)) {
            throw new InvalidArgumentException('Invalid field name');
        }

        // On s'assure qu'on a pas autre chose que ASC ou DESC
        if (!in_array($direction, [
            'ASC',
            'DESC',
        ], true)) {
            throw new InvalidArgumentException('Invalid ORDER BY direction');
        }


        $sth = $this->dbh->prepare("
            SELECT * 
            FROM articles 
            ORDER BY $sortBy $direction
        ");
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllByType(string $type): array
    {
        $sth = $this->dbh->prepare('
            SELECT * 
            FROM articles 
            WHERE type = :type
        ');

        $sth->execute([':type' => $type]);
        
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}
