<?php

namespace App\Controllers;

use App\Services\API\TrendingMovies;

class Site extends Controller
{
    public function index()
    {
        $trendingMovies = new TrendingMovies();
        return $this->view('home', [
            'trendingMovies' => $trendingMovies->getMovies()
        ]);
    }
}
