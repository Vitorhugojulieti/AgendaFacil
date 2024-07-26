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
            $db = new Db();
            $db->connect();
            $companys = new Company();
            $companys = $companys->getAll($db);
            
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
}

?>