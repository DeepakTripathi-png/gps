<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartJT707ASocket extends Command
{
    // The name and signature of the console command
    protected $signature = 'socket:jt707A';

    // The console command description
    protected $description = 'Starts the JT707A Socket Server';

    public function __construct()
    {
        parent::__construct();
        // Allow script to run indefinitely
        set_time_limit(0);
    }

    public function handle()
    {
        $host = '45.79.121.28'; 
        $port = 7007;

        // Create the socket
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            $this->error("Socket creation failed: " . socket_strerror(socket_last_error()));
            return;
        }

        socket_set_option($socket, SOL_SOCKET, SO_KEEPALIVE, 1);

        if (socket_bind($socket, $host, $port) === false) {
            $this->error("Socket bind failed: " . socket_strerror(socket_last_error()));
            return;
        }

        if (socket_listen($socket, 5) === false) {
            $this->error("Socket listen failed: " . socket_strerror(socket_last_error()));
            return;
        }

        $this->info("Server listening on port $port");

        // Accept clients indefinitely
        while (true) {
            $clientSocket = socket_accept($socket);
            if ($clientSocket === false) {
                $this->error("Failed to accept connection: " . socket_strerror(socket_last_error()));
                continue;
            }

            $this->info("Client connected.");

            // Handle the client connection
            $this->handleClient($clientSocket);
        }

        socket_close($socket);
    }

    private function handleClient($clientSocket)
    {
        while (true) {
            socket_set_option($clientSocket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => 15, 'usec' => 0]);

            $data = socket_read($clientSocket, 16384);
            if ($data === false) {
                $this->error("Failed to read data: " . socket_strerror(socket_last_error($clientSocket)));
                break;
            }

            if (empty($data)) {
                $this->info("Client disconnected.");
                break; 
            }

            $rawData = bin2hex($data);
            $this->info("Received data: $rawData");

            // Send data to the API
            $apiUrl = 'https://gpspackseal.in/api/handle-jt707a-data';
            $apiResponse = $this->postDataToUrl($apiUrl, ['data' => $rawData]);
            $this->info("API Response: $apiResponse");
            
            
            if ($apiResponse=== false) {
                $responseToClient = "";
            } else {
                if (isset($apiResponse)) {
                    if (is_string($apiResponse)) {
                        $responseToClient = hex2bin($apiResponse);
                    } else {
                        $responseToClient = hex2bin($apiResponse);
                    }
                } else {
                    $responseToClient = "";
                }
            }

            @socket_write($clientSocket, $responseToClient, strlen($responseToClient));
           
        }

        socket_close($clientSocket);
    }

    private function postDataToUrl($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_POST, true); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 

        $response = curl_exec($ch);

        if ($response === false) {
            $this->error('Curl error: ' . curl_error($ch)); 
            return false;
        }

        curl_close($ch);
        return $response; 
    }
}
