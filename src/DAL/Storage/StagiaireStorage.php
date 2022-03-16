<?php

namespace App\DAL\Storage;

interface StagiaireStorage
{
    public function insert(
        string $nom
    ): int;

    public function find(int $id): ?array;
    public function findAll(): array;

    public function update(
        string $nom,
        int $id,
    );
    public function delete(int $id);
}
