<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ToraiSocketServer extends Command
{
    protected $signature = 'socket:torai';
    protected $description = 'Start the Torai device socket server';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        set_time_limit(0);

        $host = '45.79.121.28'; // Set your host IP
        $port = 9001;           // Set your port

        $socket = $this->createSocket($host, $port);

        $this->info("Torai Server listening on port $port");

        while (true) {
            $clientSocket = @socket_accept($socket);

            if ($clientSocket === false) {
                continue;
            }

            $this->info("Client connected.");

            $this->handleClient($clientSocket);
        }
    }

    protected function createSocket($host, $port)
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            $this->error("Socket creation failed: " . socket_strerror(socket_last_error()));
            exit();
        }

        socket_set_option($socket, SOL_SOCKET, SO_KEEPALIVE, 1);

        if (socket_bind($socket, $host, $port) === false) {
            $this->error("Socket bind failed: " . socket_strerror(socket_last_error()));
            exit();
        }

        if (socket_listen($socket, 5) === false) {
            $this->error("Socket listen failed: " . socket_strerror(socket_last_error()));
            exit();
        }

        return $socket;
    }

    protected function handleClient($clientSocket)
    {
        while (true) {
            $data = @socket_read($clientSocket, 65536);
            if ($data === false) {
                break;
            }

            if (empty($data)) {
                $this->info("Client disconnected.");
                break;
            }

            // Show raw data directly in the terminal
            $this->info("Received data: $data");

        }

        socket_close($clientSocket);
    }
}
