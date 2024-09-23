<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/BaseRabbitMQ.php';

use PhpAmqpLib\Message\AMQPMessage;

class Producer extends BaseRabbitMQ
{
    public function sendMessage(string $json)
    {
        $this->channel->queue_declare('uni-stab', false, false, false, false);

        $msg = new AMQPMessage($json, ['delivery_mode' => 2]); // Mensagem persistente
        $this->channel->basic_publish($msg, '', 'uni-stab');

        echo " [x] Enviado: $json\n";
    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}

// Exemplo de uso:
$producer = new Producer();
$jsonData = json_encode(['a' => 'valorA', 'b' => 'valorB', 'c' => 'valorC']);
$producer->sendMessage($jsonData);
$producer->close();
