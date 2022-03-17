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

    // Liste des actions du controleur

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return Response
     */
    public function listStylos(Request $request): Response
    {
        /**
         *  @var Collection $articles
         */
        $articles = $this->articleManager->recupererTousLesStylos();

        return new Response(
            json_encode($articles),

            ['Content-Type' => 'application/json']
        );
    }
}