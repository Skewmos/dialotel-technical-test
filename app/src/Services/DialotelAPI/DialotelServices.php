<?php

namespace App\Services\DialotelAPI;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class DialotelServices
{
    private $client;
    private $login;
    private $password;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function connectToApi(): array
    {
        $response = $this->client->request('POST', 'https://api.example.com/login', [
            'body' => [
                'login' => $this->login,
                'password' => $this->password,
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();

        return ['statusCode' => $statusCode, 'content' => $content];
    }
}