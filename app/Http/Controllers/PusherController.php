<?php

namespace App\Http\Controllers;

use App\Events\PusherBroadcast;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;


class PusherController extends Controller
{
    public function index()
    {
        return view('liveChat');
    }

    public function broadcast(Request $request)
    {
        Log::info('Broadcast message: '.$request->message);

        broadcast(new PusherBroadcast($request->message));

        return view('broadcast',['message' => $request->message])->render();
    }

    public function receive(Request $request)
    {
        return view('receive',['message' => $request->message])->render();
}