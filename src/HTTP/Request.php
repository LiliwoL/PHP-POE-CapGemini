<?php

namespace App\HTTP;

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
     * Construction d'une requete à partir des données globales du php
     *
     * @return Request
     */
    public static function createFromGlobal() : Request
    {
        return new Request(
            $_REQUEST,
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