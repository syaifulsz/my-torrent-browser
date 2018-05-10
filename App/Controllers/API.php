<?php

namespace App\Controllers;

// models
use App\Models\Movie;

// vendors
use GuzzleHttp\Client;
use DiDom\Document;

class API extends Controller
{
    private $client;
    private $doc;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://1337x.to'
        ]);
    }

    public function get_source_search($keyword)
    {
        $response = $this->client->get("search/{$keyword}/1/");
        $body = $response->getBody();
        return $body->getContents();
    }

    public function get_source_detail($url)
    {
        if ($url) {
            $response = $this->client->get($url);
            $body = $response->getBody();
            return $body->getContents();
        }

        return null;
    }

    public function detail($url)
    {
        $source = $this->get_source_detail($url);

        if (!$source) {
            return null;
        }

        return $this->parsed_source_detail($source);
    }

    private function parsed_source_detail($source)
    {
        $doc = new Document($source);
        $btn_magnet = $doc->find('.download-links-dontblock a[href^=magnet]');

        if (!$btn_magnet) {
            return null;
        }

        return $btn_magnet[0]->getAttribute('href');
    }

    private function parsed_source_search($source)
    {
        $scrapped_list = [];
        $doc = new Document($source);
        $rows = $doc->find('.box-info-detail tr');
        foreach ($rows as $row) {

            $title = $row->find('.coll-1 a[href^=/torrent]');
            $size = $row->find('.coll-4');
            $seed = $row->find('.coll-2');
            $leeches = $row->find('.coll-3');

            if ($title && $size) {
                $title = $title[0];
                $exp_size = explode(' ', $size[0]->text());
                $scrapped_list[] = new Movie([
                    'url' => $title->getAttribute('href'),
                    'title' => $title->innerHtml(),
                    'size' => $exp_size[0],
                    'seed' => $seed[0]->innerHtml(),
                    'leeches' => $leeches[0]->innerHtml(),
                ]);
            }
        }
        return $scrapped_list;
    }

    public function search($keyword)
    {
        $source = $this->get_source_search($keyword);

        if (!$source) {
            return null;
        }

        return $this->parsed_source_search($source);
    }
}
