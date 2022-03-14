<?php

namespace App\Entite;

class Ligne
{
    public function __construct(
        private Article $article,
        private int $qte = 0
    ) {
    }

    public function getArticle(): Article
    {
        return $this->article;
    }

    public function setArticle(Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getQte(): int
    {
        return $this->qte;
    }

    public function setQte(int $qte): Ligne
    {
        $this->qte = $qte;

        return $this;
    }
}
