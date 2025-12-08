<?php

namespace App\Http\Controllers;

use App\Events\PusherBroadcast;
use App\Models\ChMessage;
use App\Models\User;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PusherController extends Controller
{
    protected ChatService $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * Display the live chat page with message history
     */
    public function index()
    {
        // Cache key for messages
        $cacheKey = 'chat_messages_latest_50';
        
        // Get messages from cache or database
        $messages = Cache::remember($cacheKey, 30, function () {
            return $this->chatService->getPublicMessages(50);
        });

        return view('liveChat', compact('messages'));
    }

    /**
     * Broadcast a message to all users
     */
    public function broadcast(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:5000|min:1',
            ]);

            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Rate limiting check
            if (!$this->chatService->canSendMessage($user->user_id)) {
                return response()->json([
                    'error' => 'You are sending messages too quickly. Please wait a moment.'
                ], 429);
            }

            $rawMessage = trim($request->get('message'));
            if (empty($rawMessage)) {
                return response()->json(['error' => 'Message cannot be empty'], 400);
            }

            // Create message using service
            $chatMessage = $this->chatService->createMessage($user->user_id, $rawMessage, 0);
            
            if (!$chatMessage) {
                return response()->json(['error' => 'Failed to save message'], 500);
            }

            // Clear cache
            Cache::forget('chat_messages_latest_50');

            // Try to broadcast the message
            if (config('broadcasting.default') === 'pusher' 
                && !empty(config('broadcasting.connections.pusher.key'))) {
                try {
                    broadcast(new PusherBroadcast(
                        $rawMessage, 
                        $user->user_id, 
                        $user->name, 
                        $user->role, 
                        $chatMessage->id
                    ))->toOthers();
                } catch (\Exception $broadcastError) {
                    \Log::warning('Broadcast event error (non-critical): ' . $broadcastError->getMessage());
                }
            }

            // Return the message HTML
            return view('broadcast', [
                'message' => $rawMessage,
                'user' => $user,
                'messageId' => $chatMessage->id,
                'timestamp' => $chatMessage->created_at
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Broadcast error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => config('app.debug') ? $e->getMessage() : 'Failed to send message. Please try again.'
            ], 500);
        }
    }

    /**
     * Receive a message (called via AJAX when receiving broadcast)
     * Fetches from database to ensure consistency
     */
    public function receive(Request $request)
    {
        $messageId = $request->get('message_id');
        
        // Try to get message from database first for consistency
        if ($messageId) {
            $chatMessage = $this->chatService->getMessageById($messageId);
            if ($chatMessage) {
                return view('receive', [
                    'message' => $chatMessage->body,
                    'user' => $chatMessage->fromUser,
                    'messageId' => $chatMessage->id,
                    'timestamp' => $chatMessage->created_at
                ]);
            }
        }
        
        // Fallback to request data if message not found in DB
        $fromId = $request->get('from_id');
        $message = $request->get('message');
        $fromName = $request->get('from_name');

        // Get user info if available
        $user = null;
        if ($fromId) {
            $user = User::select('user_id', 'name', 'email', 'role')->find($fromId);
        }

        return view('receive', [
            'message' => $message,
            'user' => $user,
            'fromName' => $fromName,
            'messageId' => $messageId ?: uniqid('msg_', true),
            'timestamp' => now()
        ]);
    }

    /**
     * Send a message (alternative endpoint - uses same logic as broadcast)
     */
    public function send(Request $request)
    {
        // Reuse broadcast logic for consistency
        return $this->broadcast($request);
    }

    /**
     * Get chat history (for loading previous messages with pagination)
     */
    public function getHistory(Request $request)
    {
        $limit = min($request->get('limit', 50), 100); // Max 100 messages
        $beforeId = $request->get('before_id');
        $afterId = $request->get('after_id');
        
        $query = ChMessage::where('to_id', 0)
            ->with('fromUser:user_id,name,email,role')
            ->orderBy('created_at', 'desc');

        // If after_id is provided, get messages after this ID (for polling)
        if ($afterId) {
            $afterMessage = ChMessage::find($afterId);
            if ($afterMessage) {
                $query->where('created_at', '>', $afterMessage->created_at);
            }
        } elseif ($beforeId) {
            // Get messages before this ID (for pagination)
            $beforeMessage = ChMessage::find($beforeId);
            if ($beforeMessage) {
                $query->where('created_at', '<', $beforeMessage->created_at);
            }
        }

        $messages = $query->limit($limit)->get();
        
        // If polling (after_id), return in ascending order
        if ($afterId) {
            $messages = $messages->reverse();
        } else {
            $messages = $messages->reverse();
        }

        return response()->json([
            'messages' => $messages,
            'has_more' => $messages->count() === $limit,
            'count' => $messages->count()
        ]);
    }
}
