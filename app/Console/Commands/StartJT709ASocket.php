<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartJT709ASocket extends Command
{
    // The name and signature of the console command
    protected $signature = 'socket:jt709A';

    // The console command description
    protected $description = 'Starts the JT709A Socket Server';

    // Set time limit to 0 to allow long-running processes
    public function __construct()
    {
        parent::__construct();
        set_time_limit(0);
    }

    // The logic of the socket server
    public function handle()
    {
        $host = '45.79.121.28'; 
        $port = 7009;

        $socket = $this->createSocket($host, $port);

        $this->info("JT709A Server listening on port $port");

        while (true) {
            $clientSocket = @socket_accept($socket); 

            if ($clientSocket === false) {
                $this->error("Failed to accept connection: " . socket_strerror(socket_last_error($socket)));
                continue; 
            }

            $this->info("Client connected.");

            $this->handleClient($clientSocket);
        }
    }

    private function createSocket($host, $port)
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

    private function handleClient($clientSocket)
    {
        while (true) {
            socket_set_option($clientSocket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => 15, 'usec' => 0]);

            $data = @socket_read($clientSocket, 32768); 
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

            $apiUrl = 'https://gpspackseal.in/api/handle-device-jt709a-data';
            $apiResponse = $this->postDataToUrl($apiUrl, ['data' => $rawData]);

            $this->info("API Response: $apiResponse");

            if ($apiResponse === false) {
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

