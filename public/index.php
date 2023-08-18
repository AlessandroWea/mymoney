<?php

session_start();

require_once '../vendor/autoload.php';
require_once '../src/config.php';
require_once '../src/functions.php';

use Alewea\Mymoney\core\App;

$app = new App;
$app->run();