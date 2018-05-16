<?php

namespace App\Models;

class Movie extends Model
{
    public $title;
    public $url;
    public $seed;
    public $leaches;
    public $size;
    public $image;
    public $year;

    public function getKeyword()
    {
        return strtolower($this->title . ($this->year ? " {$this->year}" : ''));
    }

    public function getSuggestion()
    {
        return [
            'title' => $this->title,
            'year' => $this->year,
            'image' => $this->image,
            'keyword' => $this->getKeyword()
        ];
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDisplayTitle()
    {
        return $this->getTitle() . ($this->getYear() ? " {$this->getYear()}" : null);
    }

    public function getYear()
    {
        return (float)$this->year;
    }

    public function getImageUrl()
    {
        return $this->image;
    }
}
