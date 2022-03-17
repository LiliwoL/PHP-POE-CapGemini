<?php

namespace App\Controller;

use App\BLL\StagiaireManager;
use App\Entite\Collection;
use App\Http\Request;
use App\Http\Response;

class StagiaireController
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
                'Content-Type' => 'application/json'
            ]
        );
    }

}
