<?php

require 'vendor/autoload.php';

const VIEW_DIR = __DIR__ . '/App/Views';

function isRoute($route)
{
    $request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
    $request_route = $request_uri[0];

    if ($request_route !== $route) {
        $request_route = preg_replace('{/$}', '', $request_route);
    }

    return ($request_route === $route);
}

switch (true) {

    case isRoute('/'):
        $controller = new \App\Controllers\Site();
        $controller->index();
        break;

    case isRoute('/api'):

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $controller = new \App\Controllers\TorrentAPI();
            $controller->index();
        }
        header('HTTP/1.0 404 Not Found');

        break;

    case isRoute('/api/torrent'):
        var_dump('/api/torrent');
        break;

    default:
        header('HTTP/1.0 404 Not Found');
        break;
}
