<?php

namespace App\Controller;

use App\BLL\StagiaireManager;
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
        $stagiaires = $this->stagiaireManager->listerLesStagiaires();
        
        return new Response(
            json_encode($stagiaires),
            ['Content-Type' => 'application/json']
        );
    }

}
