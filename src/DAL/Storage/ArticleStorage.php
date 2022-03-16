<?php

namespace App\DAL\Storage;

interface ArticleStorage
{
    public const TYPE_STYLO = 'STYLO';
    public const TYPE_RAMETTE = 'RAMETTE';

    public function findAll(string $sortBy, string $direction = 'ASC'): array;
    public function findAllByType(string $type): array;
    public function find(int $id): ?array;
    public function insert(
        string $marque,
        string $reference,
        string $designiation,
        float $prixUnitaire,
        int $qteStock,
        string $type,
        ?string $couleur = null,
        ?int $grammage = null
    ): int;
    public function update(
        int $id,
        string $marque,
        string $reference,
        string $designiation,
        float $prixUnitaire,
        int $qteStock,
        ?string $couleur = null,
        ?int $grammage = null,
    );
    public function delete(int $id);
}