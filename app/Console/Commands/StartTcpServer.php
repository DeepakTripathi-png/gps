<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use React\Socket\ConnectionInterface;
use React\Socket\Server as SocketServer;
use React\EventLoop\Factory as EventLoop;
use GuzzleHttp\Client;

class StartTcpServer extends Command
{
    protected $signature = 'tcp:server';
    protected $description = 'JT701 TCP Server';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $loop = EventLoop::create();
        $server = new SocketServer('45.79.121.28:7001', $loop);

        $server->on('connection', function (ConnectionInterface $connection) {
            $this->info("Client connected");

            $connection->on('data', function ($data) use ($connection) {
                $rawData = bin2hex($data);
                
               
                $this->info("Received data: $rawData");

                $response = $this->sendRawDataToController($rawData);
                
                
                 $this->info("API Response: $rawData");

                // if ($response['status'] == 'success') {
                //     $this->info("Data processed successfully by the Laravel controller.");
                //     $connection->write("(P69,0,102)"); 
                // } else {
                //     $this->error("Error in processing data.");
                //     $connection->write("(Error)"); 
                // }
            });

            // Handle disconnection
            $connection->on('close', function() {
                $this->info("Client disconnected.");
            });
        });

        $this->info("JT701 TCP Server started on 45.79.121.28:7001");
        $loop->run();
    }

    private function sendRawDataToController($rawData)
    {
        try {
            $client = new Client();
            $response = $client->post('https://gpspackseal.in/api/handle-socket-data', [
                'form_params' => ['data' => $rawData] 
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $this->error("Error sending data to controller: " . $e->getMessage());
            return ['status' => 'error'];
        }
    }
}
