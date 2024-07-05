<?php
require_once '../app/interfaces/ModelInterface.php';
require_once '../app/models/Client.php';
require_once '../app/models/Company.php';
require '../vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();


use app\core\AppExtract;
use app\core\MyApp;

$myApp = new MyApp(new AppExtract);
$myApp->controller();
$myApp->view();


?>