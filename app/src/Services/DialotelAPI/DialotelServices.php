<?php

namespace App\Services\DialotelAPI;

use PHPUnit\Util\Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class DialotelServices
{
    private $client;
    private string $login;
    private string $password;
    private string $base_api_url;

    public function __construct(HttpClientInterface $client, ParameterBagInterface $params)
    {
        $this->client = $client;
        $this->login = $params->get('env(API_LOGIN)');
        $this->password = $params->get('env(API_PASSWORD)');
        $this->base_api_url = "https://techapi.dialotel.dev/api";
    }

    public function auth(): ResponseInterface
    {
        return $this->client->request('POST', $this->base_api_url."/login", [
            'body' => [
                'login' => $this->login,
                'password' => $this->password,
            ],
        ]);
    }

    public function getHeaders(){
        $token = $this->auth();
        if (!$token) {
            throw  new Exception('An error occurred when retrieving the token');
        }

        return [
            "Authorization" => 'Bearer '. $token['token'],
        ];
    }

    public function createCustomer($email, $name = "John Does" ) {

        return $this->client->request('POST', $this->base_api_url."/customers", [
            "headers" => $this->getHeaders(),
            'body' => [
                "name"=> $name,
                "email"=> $email
            ],
        ]);
    }

    public function createCard($payload) {
        return $this->client->request('POST', $this->base_api_url."/cards", [
            "headers" => $this->getHeaders(),
            'body' => $payload,
        ]);
    }

    public function removeCard($cardId) {
        return $this->client->request('DELETE', $this->base_api_url."/cards/$cardId", [
            "headers" => $this->getHeaders(),
        ]);
    }

}