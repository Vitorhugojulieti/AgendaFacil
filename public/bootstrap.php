<?php

session_start();

use app\core\AppExtract;
use app\core\MyApp;

// require '../app/exceptions/exception.php';
require '../vendor/autoload.php';

// $whoops = new \Whoops\Run;
// $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
// $whoops->register();

$myApp = new MyApp(new AppExtract);
$myApp->controller();
$myApp->view();


?>