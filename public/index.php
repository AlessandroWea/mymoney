<?php

session_start();

define('ROOT', dirname(__FILE__));
define('SERVER_PATH', '/');

require_once '../vendor/autoload.php';
require_once '../src/config.php';
require_once '../src/functions.php';

use Alewea\Mymoney\core\App; // namespace and folders shoudl be written the same case-sensitive

$app = new App;
$app->run();