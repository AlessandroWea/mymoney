<?php

namespace Alewea\Mymoney\core;

class Controller
{
    protected function view($filename)
    {
        $path = '../src/views/' . $filename . '.view.php';
        if(file_exists($path))
        {
            require_once $path;
        }
        else
        {
            die('FILE "' . $path . '" NOT FOUND');
        }
    }
}