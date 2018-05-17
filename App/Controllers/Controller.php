<?php

namespace App\Controllers;

use App\Components\Cache;
use App\Components\View;

class Controller
{
    protected $view;
    protected $cache;

    public function __construct()
    {
        $this->view = new View();
        $this->cache = new Cache();
    }
}
