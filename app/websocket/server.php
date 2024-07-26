<?php
$host = '127.0.0.1';
$port = 8080;

$server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($server, $host, $port);
socket_listen($server);

$clients = array($server);
$clientIds = array(); // Armazena o ID do usuário associado a cada cliente
$lastProcessedIds = [
    'notifications' => 0,
    'messages' => 0
];

while (true) {
    $changed = $clients;
    socket_select($changed, $null, $null, 0, 10);

    if (in_array($server, $changed)) {
        $socket_new = socket_accept($server);
        $clients[] = $socket_new;

        $header = socket_read($socket_new, 1024);
        perform_handshaking($header, $socket_new, $host, $port);

        // Inicialmente, o ID do usuário não está disponível; pode ser recebido posteriormente
        $clientIds[(int)$socket_new] = null; 

        $response = mask(json_encode(array('type'=>'system', 'message'=>'A new user connected')));
        send_message($response);

        $found_socket = array_search($server, $changed);
        unset($changed[$found_socket]);
    }

    foreach ($changed as $changed_socket) {
        $buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
        if ($buf === false) {
            $found_socket = array_search($changed_socket, $clients);
            unset($clients[$found_socket]);
            unset($clientIds[(int)$changed_socket]);

            $response = mask(json_encode(array('type'=>'system', 'message'=>'A user disconnected')));
            send_message($response);
        } else {
            // Process the message to identify user ID
            $data = unmask($buf);
            $data = json_decode($data, true);

            if (isset($data['userId'])) {
                // Associate this socket with the user ID
                $clientIds[(int)$changed_socket] = $data['userId'];
            }
        }
    }

    check_for_updates();
}

socket_close($server);

function perform_handshaking($received_header, $client_conn, $host, $port) {
    // Código de handshake WebSocket
}

function mask($text) {
    // Código de máscara
}

function unmask($text) {
    // Código de desmascaramento
}

function send_message($msg, $userId = null) {
    global $clients, $clientIds;
    
    foreach ($clients as $client) {
        if ($client === $server) continue; // Ignore o socket do servidor

        if ($userId === null || (isset($clientIds[(int)$client]) && $clientIds[(int)$client] == $userId)) {
            @socket_write($client, $msg, strlen($msg));
        }
    }
    return true;
}

function check_for_updates() {
    global $lastProcessedIds;
    $pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');

    // Consultar novas notificações
    $stmt = $pdo->prepare('SELECT * FROM notifications WHERE id > :lastId ORDER BY id ASC');
    $stmt->execute(['lastId' => $lastProcessedIds['notifications']]);
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Consultar novas mensagens
    $stmt = $pdo->prepare('SELECT * FROM messages WHERE id > :lastId ORDER BY id ASC');
    $stmt->execute(['lastId' => $lastProcessedIds['messages']]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $updates = [];

    if ($notifications) {
        $lastProcessedIds['notifications'] = end($notifications)['id'];
        foreach ($notifications as $notification) {
            $userId = $notification['user_id']; // Supondo que a tabela `notifications` tem um campo `user_id`
            $response = mask(json_encode(array('type'=>'update', 'data'=>$notification)));
            send_message($response, $userId);
        }
    }

    if ($messages) {
        $lastProcessedIds['messages'] = end($messages)['id'];
        foreach ($messages as $message) {
            $userId = $message['user_id']; // Supondo que a tabela `messages` tem um campo `user_id`
            $response = mask(json_encode(array('type'=>'update', 'data'=>$message)));
            send_message($response, $userId);
        }
    }
}
?>