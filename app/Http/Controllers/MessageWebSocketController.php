<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\SendMessageToClientEvent;

class MessageWebSocketController extends Controller
{
     /**
     * Dispatch a WebSocket event with a message.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        $message = $request->input('message', 'Default message');
        SendMessageToClientEvent::dispatch($message);
        return response()->json(['status' => 'Message sent']);
    }
}
