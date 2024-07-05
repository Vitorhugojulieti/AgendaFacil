<?php

namespace app\classes;

class ImageUpload{
    private $targetDir;
    private $maxFileSize;
    private $allowedTypes;

    public function __construct($targetDir = 'app/uploads/', $maxFileSize = 5000000, $allowedTypes = ['jpg', 'jpeg', 'png']) {
        $this->targetDir = $targetDir;
        $this->maxFileSize = $maxFileSize;
        $this->allowedTypes = $allowedTypes;
    }

    public function upload($file) {
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $newName = uniqid().'.'.$imageFileType;
        $targetFile = $this->targetDir.$newName;

        if (!is_dir($this->targetDir)) {
            mkdir($this->targetDir, 0777, true);
        }

        // Verifica se o arquivo é uma imagem real
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return ["success" => false, "message" => "O arquivo não é uma imagem."];
        }

        // Verifica o tamanho do arquivo
        if ($file["size"] > $this->maxFileSize) {
            return ["success" => false, "message" => "O arquivo é muito grande."];
        }

        // Verifica o tipo de arquivo
        if (!in_array($imageFileType, $this->allowedTypes)) {
            return ["success" => false, "message" => "Apenas arquivos JPG, JPEG, PNG e GIF são permitidos."];
        }

        // Verifica se o arquivo já existe
        if (file_exists($targetFile)) {
            return ["success" => false, "message" => "O arquivo já existe."];
        }

        // Tenta mover o arquivo
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return ["success" => true, "link" => $targetFile];
        } else {
            return ["success" => false,"message"=>"Erro ao enviar imagem."];
        }
    }
}


?>
