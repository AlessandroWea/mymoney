<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;

class LogoutController extends Controller
{
    public function actionIndex()
    {
        session_unset();
        session_destroy();

        $this->redirect('login');
    }
}