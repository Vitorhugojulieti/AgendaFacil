<?php
require_once '../app/interfaces/ModelInterface.php';
require_once '../app/models/Client.php';
require_once '../app/models/Company.php';
require '../vendor/autoload.php';

ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.gc_maxlifetime', 1440);
// ini_set('display_errors', 0);  // Não exibe erros em produção
// ini_set('log_errors', 1);  
session_start();
session_regenerate_id(true);
if(empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();


use app\core\AppExtract;
use app\core\MyApp;

// try {
    $myApp = new MyApp(new AppExtract);
    $myApp->controller();
    $myApp->view();
// } catch (\Throwable $th) {
    // $notFoundPage = file_get_contents('../app/views/notFound.php');
    // echo $notFoundPage;
// }


?>