<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageEvent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function send(Request $request)
{
    try {

        $user = $request->user;
        $message = $request->message;
          broadcast(new ChatMessageEvent($message, $user))->toOthers();

         return response()->json(['status' => 'ok']);


    } catch (\Throwable $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
}

}
