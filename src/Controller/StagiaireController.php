<?php

namespace App\Controller;

use App\Http\Request;
use App\Http\Response;
use App\Entite\Collection;
use App\BLL\StagiaireManager;
use App\Controller\AbstractController;

class StagiaireController extends AbstractController
{
    public function __construct( private StagiaireManager $stagiaireManager )
    {
    }

    // Liste des actions du controleur


    /**
     * Undocumented function
     *
     * @param Request $request
     * @return Response
     */
    public function list( Request $request ): Response
    {
        /**
         * @var ArrayObject $stagiaires
         */
        $stagiaires = $this->stagiaireManager->listerLesStagiaires();

        // Ici on devrait faire appel à la vue
        
        return new Response(
            // Body de la réponse
            json_encode( $stagiaires ),

            // Headers de la réponse
            // On peut ajouter tous les headers que l'on souhaite!
            // Certains sont réservés

            [
                // Ici le type de contenu qui est renvoyé sera du JSON
                // https://developer.mozilla.org/fr/docs/Web/HTTP/Headers/Content-Type
                // https://developer.mozilla.org/fr/docs/Web/HTTP/Basics_of_HTTP/MIME_types
                // 'Content-Type' => 'video/ogg'
                'Content-Type' => 'application/json',

                'Status-Code' => 418
            ]
        );
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return Response
     */
    public function listView( Request $request ): Response
    {
        /**
         * @var ArrayObject $stagiaires
         */
        $stagiaires = $this->stagiaireManager->listerLesStagiaires();

        // Renvoi d'une réponse avec TWIG
        return $this->render(
            'stagiaire/list.html.twig',
            [
                'stagiaires' => $stagiaires
            ]
        );

        // Renvoi sans TWIG
        /*
            return $this->renderSansTwig(
                'stagiaire/list',
                [
                    'stagiaires' => $stagiaires
                ]
            );
        */
    }

    /**
     * Action de création GET ou POST
     *
     * @param Request $request
     * @return Response
     */
    public function create( Request $request ): Response
    {
        // En GET on ne fait que renvoyer la vue
        return $this->render(
            'stagiaire/create.html.twig',
            []
        );
    }
}
