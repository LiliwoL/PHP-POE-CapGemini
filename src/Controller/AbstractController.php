<?php

namespace App\Controller;

use App\Http\Response;


abstract class AbstractController
{
    public function render ( string $template, ?array $args = [] )
    {
        // Transfrmation du tableau en variables
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
}