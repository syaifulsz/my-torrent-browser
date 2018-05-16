<?php

namespace App\Services\API;

use GuzzleHttp\Client;

class API
{
    protected $client;

    public function __construct($apiBaseUri = null)
    {
        if ($apiBaseUri) {
            $this->client = new Client([
                'base_uri' => $apiBaseUri
            ]);
        } else {
            $this->client = new Client();
        }
    }
}
