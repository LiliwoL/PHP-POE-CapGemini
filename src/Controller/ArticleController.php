<?php

namespace App\Controller;

use App\BLL\ArticleManager;
use App\BLL\StagiaireManager;
use App\Http\Request;
use App\Http\Response;

class ArticleController
{
    public function __construct(private ArticleManager $articleManager)
    {
    }

    public function listStylos(Request $request): Response
    {
        $articles = $this->articleManager->recupererTousLesStylos();

        return new Response(
            json_encode($articles),
            ['Content-Type' => 'application/json']
        );
    }
}