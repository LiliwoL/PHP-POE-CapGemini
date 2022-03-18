<?php

namespace App\Controller;

use App\Http\Request;
use App\Http\Response;
use App\BLL\ArticleManager;
use App\DAL\Storage\ArticleStorage;

class ArticleController extends AbstractController
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
         *  @var Collection $stylos
         */
        $stylos = $this->articleManager->recupererTousLesStylos();

        /* On appelle désormais $this->render */
        /*
        return new Response(
            json_encode($stylos),

            ['Content-Type' => 'application/json']
        );*/

        return $this->render(
            'articles/list.html.twig', 
            [
                'articles' => $stylos,
            ]
        );
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return Response
     */
    public function listRamettes(Request $request): Response
    {
        /**
         *  @var Collection $ramettes
         */
        $ramettes = $this->articleManager->recupererToutesLesRamettes();

        return $this->render(
            'articles/list.html.twig', 
            [
                'articles' => $ramettes,
            ]
        );
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return Response
     */
    public function listArticles(Request $request): Response
    {
        /**
         *  @var Collection $articles
         */
        //$articles = $this->articleManager->recupererTousLesArticles();

        $stylos = $this->articleManager->recupererTousLesStylos();
        $ramettes = $this->articleManager->recupererToutesLesRamettes();


        return $this->render(
            'articles/listArticles.html.twig', 
            [
                'stylos' => $stylos,
                'ramettes' => $ramettes
            ]
        );
    }

    public function create(Request $request): Response
    {
        if ($request->isMethodPost()) 
        {
            // Ramette?
            if ($request->get('type') === ArticleStorage::TYPE_RAMETTE)
            {
                $this->articleManager->creerRamette(
                    $request->get('marque'),
                    $request->get('reference'),
                    $request->get('designation'),
                    $request->get('prixUnitaire'),
                    $request->get('qteStock'),
                    $request->get('grammage')
                );
            }else {
                $this->articleManager->creerStylo(
                    $request->get('marque'),
                    $request->get('reference'),
                    $request->get('designation'),
                    $request->get('prixUnitaire'),
                    $request->get('qteStock'),
                    $request->get('couleur')
                );
            }

            return new Response('', ['Location' => $_ENV['URL_BASE'] . '/articles']);
        }else{
            return $this->render('articles/create.html.twig');
        }        
    }
}