<?php

namespace App\Controllers;

class Controller
{
    protected function view($template_name, array $params = [], $return_string = false) {

        $template = VIEW_DIR . "/{$template_name}.php";

        if (!file_exists($template)) {
            throw new \Error('Template file not exist!');
        }

        extract($params, EXTR_SKIP);

        ob_start();
        require(VIEW_DIR . "/{$template_name}.php");
        $render_output = ob_get_contents();
        ob_end_clean();

        if ($return_string) {
            return $render_output;
        }

        echo $render_output;
    }    
}
