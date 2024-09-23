<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/BaseRabbitMQ.php';

class Consumer extends BaseRabbitMQ
{   
    public function consume()
    {
        echo " [*] Aguardando por mensagens. Pressione CTRL+C para sair.\n";

        $callback = function ($msg) {
            $data = json_decode($msg->body, true);
            echo " [x] Recebido: ", print_r($data, true), "\n";
        };

        $this->channel->basic_consume('uni-stab', '', false, false, false, false, $callback);

    }
}

// Exemplo de uso:
$consumer = new Consumer();
$consumer->consume();
