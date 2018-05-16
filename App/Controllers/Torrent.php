<?php

namespace App\Controllers;

use App\Services\API\Torrent as TorrentAPI;

class Torrent extends Controller
{
    protected $service;
    public function __construct()
    {
        $this->service = new TorrentAPI();
    }

    public function index()
    {
        header('Content-Type: application/json');

        if (!empty($_GET['search'])) {
            $response = $this->service->search(urlencode($_GET['search']));
            echo json_encode($response);
            die();
        }

        if (!empty($_GET['detail'])) {
            $response = $this->service->detail($_GET['detail']);
            echo json_encode($response);
            die();
        }

        echo json_encode([]);
    }
}
