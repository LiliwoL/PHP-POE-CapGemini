<?php

namespace App\DAL\Storage;

use DateTime;

interface StagiaireStorage
{
    public function insert(
        string $nom,
        DateTime $ddn
    ): int;

    public function find(int $id): ?array;
    public function findAll(): array;

    public function update(        
        string $nom,
        DateTime $ddn,
        int $id,
    );
    public function delete(int $id);
}