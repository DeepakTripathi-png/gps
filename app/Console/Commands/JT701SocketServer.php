<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class JT701SocketServer extends Command
{
   
    protected $signature = 'socket:jt701'; 
    protected $description = 'Start the JT701 device socket server';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        set_time_limit(0);

        $host = '45.79.121.28'; 
        $port = 7001;

        $socket = $this->createSocket($host, $port);

        $this->info("JT701 Server listening on port $port");

        while (true) {
            $clientSocket = @socket_accept($socket); 
            
            if ($clientSocket === false) {
                Log::error("Failed to accept connection: " . socket_strerror(socket_last_error($socket)));
                continue; // Go back to waiting for a new connection
            }

            $this->info("Client connected.");

            // Handle client connection
            $this->handleClient($clientSocket);
        }
    }

    protected function createSocket($host, $port)
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            Log::error("Socket creation failed: " . socket_strerror(socket_last_error()));
            exit();
        }

        socket_set_option($socket, SOL_SOCKET, SO_KEEPALIVE, 1);

        if (socket_bind($socket, $host, $port) === false) {
            Log::error("Socket bind failed: " . socket_strerror(socket_last_error()));
            exit();
        }

        if (socket_listen($socket, 5) === false) {
            Log::error("Socket listen failed: " . socket_strerror(socket_last_error()));
            exit();
        }

        return $socket;
    }

    protected function handleClient($clientSocket)
    {
        while (true) {
            socket_set_option($clientSocket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => 15, 'usec' => 0]);

            $data = @socket_read($clientSocket, 32768);
            if ($data === false) {
                Log::error("Failed to read data: " . socket_strerror(socket_last_error($clientSocket)));
                break;
            }

            if (empty($data)) {
                $this->info("Client disconnected.");
                break;
            }

            $rawData = bin2hex($data);
            $this->info("Received data: $rawData");

            // Send the raw data to the API and get the response
            $apiUrl = 'https://gpspackseal.in/api/handle-socket-data';
            $apiResponse = $this->postDataToUrl($apiUrl, ['data' => $rawData]);

            if ($apiResponse === false) {
                Log::error('Failed to send data to the API.');
                $responseToClient = "Error: Unable to process your request.";
            } else {
                $apiResponseData = json_decode($apiResponse, true);

                if (isset($apiResponseData['message'])) {
                    $this->info("API Response: " . $apiResponseData['message']);
                    $responseToClient = $apiResponseData['message'];
                } else {
                    $responseToClient = "Error: No message returned from API.";
                }
            }

            @socket_write($clientSocket, $responseToClient, strlen($responseToClient));
        }

        socket_close($clientSocket);
    }

    protected function postDataToUrl($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);

        if ($response === false) {
            Log::error('Curl error: ' . curl_error($ch));
            return false;
        }

        curl_close($ch);
        return $response;
    }
}
