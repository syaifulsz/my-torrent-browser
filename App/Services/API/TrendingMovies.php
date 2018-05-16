<?php

namespace App\Services\API;

// models
use App\Models\Movie;

// vendors
use DiDom\Document;

class TrendingMovies extends API
{
    public function __construct($apiBaseUri = 'https://yts.gg')
    {
        return parent::__construct($apiBaseUri);
    }

    public function getMovies()
    {
        $response = $this->client->get('/');
        $body = $response->getBody();
        $source = $body->getContents();

        if ($source) {

            $scrapped_list = [];
            $doc = new Document($source);
            $element_movie_wrappers = $doc->find('.browse-movie-wrap');
            foreach ($element_movie_wrappers as $wrapper) {

                $title = $wrapper->find('.browse-movie-title')[0]->text();
                $year = $wrapper->find('.browse-movie-year')[0]->text();
                $image = $wrapper->find('img.img-responsive')[0]->getAttribute('src');

                $scrapped_list[] = new Movie([
                    'title' => $title,
                    'year' => $year,
                    'image' => $image
                ]);
            }

            if ($scrapped_list) {
                return $scrapped_list;
            }
        }

        return [];
    }
}
