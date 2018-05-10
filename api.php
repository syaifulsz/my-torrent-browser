<?php

require 'vendor/autoload.php';

header('Content-Type: application/json');

$api = new \App\Controllers\API();

if (!empty($_GET['search'])) {
    $response = $api->search(urlencode($_GET['search']));
    echo json_encode($response);
    die();
}

if (!empty($_GET['detail'])) {
    $response = $api->detail($_GET['detail']);
    echo json_encode($response);
    die();
}

echo json_encode([]);
