<?php
// require 'vendor/autoload.php';

// use ElephantIO\Client;
// use ElephantIO\Engine\SocketIO\Version2X;

// // Configura a conexão com o servidor Socket.io
// $clientId = 123; // ID do cliente no banco de dados
// $client = new Client(new Version2X("http://localhost:3000"));

// // Conecta e registra o cliente
// $client->initialize();
// $client->emit('register', $clientId);

// // Recebe notificações do servidor
// $client->on('notification', function($data) {
//     echo "Nova notificação recebida: " . print_r($data, true) . "\n";
// });

// // Mantém a conexão aberta e processa eventos
// while (true) {
//     $client->wait();
// }
require '../../vendor/autoload.php';


use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;

$client = new Client(new Version1X('http://localhost:3000'));

try {
    // Conecta ao servidor
    $client->connect(); // Atualize de initialize() para connect()

    // Envia uma mensagem para o servidor
    $client->emit('message', ['text' => 'Olá, servidor!']);

    // Recebe uma resposta
    $client->on('response', function ($data) {
        echo 'Resposta do servidor: ' . $data . PHP_EOL;
    });

    // Desconecta
    $client->close();
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage() . PHP_EOL;
}

?>