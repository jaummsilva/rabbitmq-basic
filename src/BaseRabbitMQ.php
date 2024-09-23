<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Config.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

class BaseRabbitMQ
{
    protected $connection;
    protected $channel;

    public function __construct()
    {
        // Carrega as variáveis de ambiente do .env
        Config::getInstance();

        $this->connection = new AMQPStreamConnection(
            Config::get('RABBITMQ_HOST'),
            Config::get('RABBITMQ_PORT'),
            Config::get('RABBITMQ_USER'),
            Config::get('RABBITMQ_PASS'),
        );

        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('task_queue', false, true, false, false);
    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
