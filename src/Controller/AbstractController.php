<?php

namespace App\Controller;

use App\Http\Response;


abstract class AbstractController
{
    /**
     * Méthode de rendu sazns le moteur TWIG
     *
     * @deprecated version
     * 
     * @param string $template
     * @param array|null $args
     * @return Response
     */
    public function renderSansTwig ( string $template, ?array $args = [] )
    {
        // ********************* SANS TWIG ************************
        
        // Transformation du tableau en variables
        // https://www.php.net/manual/en/function.extract.php
        extract($args);

        // Chargement du contenu du fichier template
        $content = file_get_contents( __ROOT__ . 'templates/' . $template . '.php');

        // Application des valeurs des variables récupérées plus haut        
        ob_start();
            eval ( substr($content, 5) );
            $body = ob_get_contents();
        ob_end_clean();

        return new Response ($body);
    }

    /**
     * Undocumented function
     *
     * @param string $template
     * @param array|null $args
     * @return Response Renvoi une réponse avec le rendu TWIG
     */
    public function render ( string $template, ?array $args = [] )
    {
        // ********************* Avec TWIG ************************        
        $body = __TWIG__->render(
            $template,
            $args
        );

        return new Response ($body);
    }
}