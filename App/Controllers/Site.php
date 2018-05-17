<?php

namespace App\Controllers;

use App\Services\API\TrendingMovies;

class Site extends Controller
{
    public function index()
    {
        $cacheKey = __CLASS__ .'::'. __FUNCTION__;
        $view = null;

        if ($view = $this->cache->get($cacheKey)) {
            echo $view;
        }

        $trendingMovies = new TrendingMovies();
        $view = $this->view->render('home', [
            'trendingMovies' => $trendingMovies->getMovies()
        ], true);

        $this->cache->set($cacheKey, $view, 3600);

        echo $view;
    }
}
