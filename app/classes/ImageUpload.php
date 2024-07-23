<?php

namespace app\classes;

class ImageUpload {
    private $targetDir;
    private $maxFileSize;
    private $allowedTypes;

    public function __construct($targetDir = 'app/uploads/', $maxFileSize = 5000000, $allowedTypes = ['jpg', 'jpeg', 'png']) {
        $this->targetDir = $targetDir;
        $this->maxFileSize = $maxFileSize;
        $this->allowedTypes = $allowedTypes;
    }

    public function upload($file) {
        // Verifica se houve erro no upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ["success" => false, "message" => "Erro ao fazer upload do arquivo: " . $this->getUploadError($file['error'])];
        }

        // Filtra e sanitiza o nome do arquivo
        $file["name"] = filter_var($file["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Obtém a extensão do arquivo
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $newName = uniqid() . '.' . $imageFileType;
        $targetFile = $this->targetDir . $newName;

        // Cria o diretório de destino se não existir
        if (!is_dir($this->targetDir)) {
            mkdir($this->targetDir, 0777, true);
        }

        // Verifica se o arquivo temporário existe
        if (!file_exists($file["tmp_name"])) {
            return ["success" => false, "message" => "Arquivo temporário não encontrado. Caminho: " . $file["tmp_name"]];
        }

        // Verifica se o arquivo é uma imagem real
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return ["success" => false, "message" => "O arquivo não é uma imagem. Caminho: " . $file["tmp_name"]];
        }

        // Verifica o tamanho do arquivo
        if ($file["size"] > $this->maxFileSize) {
            return ["success" => false, "message" => "O arquivo é muito grande. Tamanho: " . $file["size"]];
        }

        // Verifica o tipo de arquivo
        if (!in_array($imageFileType, $this->allowedTypes)) {
            return ["success" => false, "message" => "Apenas arquivos JPG, JPEG, PNG são permitidos. Tipo: " . $imageFileType];
        }

        // Verifica se o arquivo já existe
        if (file_exists($targetFile)) {
            return ["success" => false, "message" => "O arquivo já existe. Caminho: " . $targetFile];
        }

        // Tenta mover o arquivo
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return ["success" => true, "link" => $targetFile];
        } else {
            $error = error_get_last();
            return ["success" => false, "message" => "Erro ao enviar imagem: " . $error['message']];
        }
    }

    private function getUploadError($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return "O arquivo excede o limite de tamanho definido no php.ini.";
            case UPLOAD_ERR_FORM_SIZE:
                return "O arquivo excede o limite de tamanho definido no formulário.";
            case UPLOAD_ERR_PARTIAL:
                return "O upload do arquivo foi feito parcialmente.";
            case UPLOAD_ERR_NO_FILE:
                return "Nenhum arquivo foi enviado.";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Pasta temporária ausente.";
            case UPLOAD_ERR_CANT_WRITE:
                return "Falha em escrever o arquivo em disco.";
            case UPLOAD_ERR_EXTENSION:
                return "Uma extensão do PHP interrompeu o upload do arquivo.";
            default:
                return "Erro desconhecido.";
        }
    }

}

?>
