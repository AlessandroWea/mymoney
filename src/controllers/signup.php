<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;

class Signup extends Controller
{
    public function index()
    {
        $this->view('signup');
    }
}