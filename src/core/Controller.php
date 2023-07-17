<?php

namespace Alewea\Mymoney\core;

class Controller
{
    protected function view($filename, $data = [])
    {
        extract($data);
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

    public function redirect(string $path)
    {
		header('Location: /'.$path);
		exit();
    }

    public function isPost() : bool
    {
        return ($_SERVER['REQUEST_METHOD'] == 'POST');
    }
}