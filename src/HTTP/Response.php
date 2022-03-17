<?php

namespace App\Http;

class Response
{
    public function __construct(
        private string $body,
        private ?array $headers = []
    )
    {
        if (!isset($this->headers['Content-Type'])) {
            $this->headers['Content-Type'] = 'text/html';
        }
        if (!isset($this->header['Status-Code'])) {
            $this->headers['Status-Code'] = 200;
        }
    }
    
    /**
     * Quand on fait un appel a cette classe
     *
     * @return void
     */
    public function __invoke()
    {
        http_response_code($this->headers['Status-Code']);

        foreach ($this->headers as $key => $value) {
            header($key.': '.$value);
        }

        // On ajoute un header de réponse personnalisé
        header('Application: MadeBy ENI');

        echo $this->body;
    }
}