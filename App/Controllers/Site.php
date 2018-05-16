<?php

namespace App\Controllers;

class Site extends Controller
{
    public function index()
    {
        return $this->view('home');
    }
}
