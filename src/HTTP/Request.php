<?php

namespace App\HTTP;

use PharIo\Manifest\InvalidUrlException;

class Request
{
    private $request = [];

    /**
     * Constructeur
     *
     * @param array $requestHttp
     * @param boolean $isMethodPost
     */
    public function __construct( array $requestHttp, private $isMethodPost = false)
    {
        $this->request = $requestHttp;
    }

    /**
     * Construction d'une instance request à partir des données globales du php
     *
     * @return Request
     */
    public static function createFromGlobal() : Request
    {
        /*
            Ce code permettrait d'ajouter un test des entêtes de la requête
            Pour vérifier la sécurité, une autorisation par exemple
        */
            // On pourrait tester ici le contenu des headers
            // https://developer.mozilla.org/en-US/docs/Web/HTTP/Authentication#authentication_schemes
            // Ici on exigerait que la requête contienne le header Auhorization et sa valeur à ENI
           /*  if ( $_SERVER['HTTP_AUTHORIZATION'] &&  $_SERVER['HTTP_AUTHORIZATION'] === "ENI")
            {
                return new Request(
                    // Contenu de la requête fourni par le serveur dans la variable globale $_REQUEST
                    $_REQUEST,
    
                    // La requête en cours est elle de type POST?
                    $_SERVER['REQUEST_METHOD'] === 'POST'
                );
            }else{
                throw new InvalidUrlException("Interdit");
            } */
        /*
            ----
        */

        return new Request(
            // Contenu de la requête fourni par le serveur dans la variable globale $_REQUEST
            $_REQUEST,

            // La requête en cours est elle de type POST?
            $_SERVER['REQUEST_METHOD'] === 'POST'
        );
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isMethodPost() : bool
    {
        return $this->isMethodPost;
    }

    /**
     * Undocumented function
     *
     * @param string $field
     * @return void
     */
    public function get( string $field )
    {
        return $this->request[ $field ] ?? null;
    }
}