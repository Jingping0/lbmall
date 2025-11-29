<?php

namespace App\Http\Controllers;

use App\Events\PusherBroadcast;
use Illuminate\Http\Request;

class PusherController extends Controller
{
    public function index()
    {
        return view('liveChat');
    }

    public function broadcast(Request $request)
    {
        $message = $request->get('message');

        event(new PusherBroadcast($message));

        return response()->json(['status' => 'ok']);
    }

    public function receive(Request $request)
    {
        return view('receive', ['message' => $request->get('message')]);
    }

    public function send(Request $request)
    {
        event(new PusherBroadcast($request->message));
        return ['sent' => true];
    }
}
