<?php

namespace App;

use App\HTTP\Request;
use App\Http\Response;
use InvalidArgumentException;
use App\Controller\ArticleController;
use App\Controller\StagiaireController;


class Router
{
    public function __invoke()
    {
        // Utiliser le tableau global de requête pour créer une instance Request
        $request = Request::createFromGlobal();


       // *************  Création de le table de routage
        $dispatcher = \FastRoute\simpleDispatcher(
            function( \FastRoute\RouteCollector $r )
            {
                // Routes de l'application
                $r->addRoute(
                    'GET',
                    '/articles',
                    [ ArticleController::class, 'listArticles' ]
                );

                /*
                    Stagiaires
                */
                $r->addRoute(
                    'GET',
                    '/',
                    [ StagiaireController::class, 'listView' ]
                );

                $r->addRoute(
                    'GET',
                    '/create',
                    [ StagiaireController::class, 'create' ]
                );
                $r->addRoute(
                    'POST',
                    '/create',
                    [ StagiaireController::class, 'create' ]
                );
            }
        );

        // ************* Interpréter la requête de l'utilisateur
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Nettoyage de l'uri pour prendre en compte les sous dossiers et non réécriture des urls
        $uri = str_replace( $_ENV['URL_BASE'], "", $uri);

        // Nettoyage de l'uri pour virer les éventuels params en GET
        if ( false !==  ($pos = strpos( $uri, '?') ) )
        {
            // On negarde que l'uri du début jusqu'au ?
            $uri = substr( $uri, 0, $pos);
        }

        // Decode de l'url
        $uri = rawurldecode( $uri );

        // *************  Dispatch en fonction de l'url et de la méthode
        $routeInfo = $dispatcher->dispatch(
            $httpMethod,
            $uri
        );


        // Lecture des infos de la route
        // Pour rappel de ce que peut contenir $routeInfo:
        /*
             [self::NOT_FOUND]
        *     [self::METHOD_NOT_ALLOWED, ['GET', 'OTHER_ALLOWED_METHODS']]
        *     [self::FOUND, $handler, ['varName' => 'value', ...]]
        */
        switch ( $routeInfo[0] )
        {
            // Route non trouvée
            case \FastRoute\Dispatcher::NOT_FOUND:
                return new Response(
                    'Route non Trouvée',
                    [
                        'Status-code' => 404
                    ]
                );
                break;

            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                return new Response(
                    'Methode non permise',
                    [
                        'Status-code' => 405
                    ]
                );
                break;

            case \FastRoute\Dispatcher::FOUND:
                
                $target = $routeInfo[1];
                $vars = $routeInfo[2];

                // Pour rappel, $target contiendra:
                // [  StagiaireController::class, 'listView' ]
                $controller = DependencyInjectionContainer::getInstance()->get( $target[0] );

                // La méthode existe bien dans le controleur?
                $action = $target[1];
                if ( ! method_exists( $controller, $action) )
                {
                    throw new InvalidArgumentException( "L'action $action n'existe pas" );
                }

                // Appel de l'action du controleur spécifiée dans $target[1]
                $reponse = $controller->$action( $request );

                $reponse();
                break;
        }
    }
}