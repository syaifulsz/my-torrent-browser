<?php

namespace App\Models;

class Model
{
    protected $__raw_data;

        public function __construct($raw_data = [])
        {
            $this->__raw_data = $raw_data;

            if ($raw_data) {
                foreach ($raw_data as $property => $value) {

                    if (property_exists($this, $property)) {
                        $this->$property = $value;
                    }
                }
            }
        }

        public function get_raw_data()
        {
            return $this->__raw_data;
        }

        public function get_data()
        {
            $array = [];
            foreach (get_object_vars($this) as $key => $value) {
                if ($key !== '__raw_data') {
                    $array[$key] = $value;    
                }
            }

            return $array;
        }
}
