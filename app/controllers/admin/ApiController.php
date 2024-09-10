<?php

namespace app\controllers\admin;
use app\models\Company;
use app\models\database\Db;

class ApiController {
    public array $data = [];
    public string $view;
    public string $master = 'masterapi.php';

    public function getDataForView() {
  
        try {
            // $db = new Db();
            // $db->connect();
            // $companys = new Company();
            // $companys = $companys->getAll($db);
            $companys = $_SESSION['collaborator']->getIdCompany();
            
            // Limpa o buffer de saída e descarta o conteúdo
            ob_end_clean();
            
            // Envia a resposta JSON
            header('Content-Type: application/json');
            echo json_encode($companys);
        } catch (\Exception $e) {
            // Limpa o buffer de saída e descarta o conteúdo
            ob_end_clean();
            
            // Log do erro
            error_log("Erro ao buscar dados: " . $e->getMessage());
            echo json_encode(['error' => 'Erro ao buscar dados']);
        }

        $this->view = 'ApiController.php';
        $this->data = [
            'title'=>'api',
            'master'=>'ApiController.php',
        ];
    }
    
    // public function getIdCompany(){
    //     header('Content-Type: application/json');

    //     $response = [
    //         'user_id' => isset($_SESSION['collaborator']) ? $_SESSION['collaborator']->getIdCompany() : null
    //     ];

    //     echo json_encode($response);

    //     $this->view = 'ApiController.php';
    //     $this->data = [
    //         'title'=>'api',
    //         'master'=>'ApiController.php',
    //     ];
    // }

    public function getNotifications() {
        try {
            if($_SESSION['collaborator'] && $_SESSION['auth']){
                $db = new Db();
                $db->connect();
                $notifications = new Notification();
                $notifications = $notifications->getByCompany($db, $_SESSION['collaborator']->getIdCompany());
                // Limpa o buffer de saída e descarta o conteúdo
                ob_end_clean();
                // Envia a resposta JSON
                header('Content-Type: application/json');
                echo json_encode($notifications);
            }else{
                error_log("Erro ao buscar dados: " . $e->getMessage());
                echo json_encode(['error' => 'Erro ao buscar dados']);
            }
           
        } catch (\Exception $e) {
            // Limpa o buffer de saída e descarta o conteúdo
            ob_end_clean();
            // Log do erro
            error_log("Erro ao buscar dados: " . $e->getMessage());
            echo json_encode(['error' => 'Erro ao buscar dados']);
        }

        $this->view = 'ApiController.php';
        $this->data = [
            'title'=>'api',
            'master'=>'ApiController.php',
        ];
    }
}

?>