<?php

namespace App\Services;

use App\Models\ChMessage;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatService
{
    /**
     * Sanitize message content for storage (remove HTML, normalize whitespace)
     */
    public function sanitizeMessage(string $message): string
    {
        // Trim whitespace
        $message = trim($message);
        
        // Remove excessive whitespace (keep single spaces and line breaks)
        $message = preg_replace('/[ \t]+/', ' ', $message);
        
        // Remove any HTML tags for security
        $message = strip_tags($message);
        
        return $message;
    }

    /**
     * Get messages for public chat with pagination
     */
    public function getPublicMessages(int $limit = 50, ?string $beforeId = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = ChMessage::where('to_id', 0)
            ->with('fromUser:user_id,name,email,role')
            ->orderBy('created_at', 'desc');

        if ($beforeId) {
            $beforeMessage = ChMessage::find($beforeId);
            if ($beforeMessage) {
                $query->where('created_at', '<', $beforeMessage->created_at);
            }
        }

        return $query->limit($limit)->get()->reverse();
    }

    /**
     * Create and save a chat message
     */
    public function createMessage(int $fromId, string $body, int $toId = 0): ?ChMessage
    {
        try {
            // Sanitize message (removes HTML, normalizes whitespace)
            $sanitizedBody = $this->sanitizeMessage($body);
            
            if (empty($sanitizedBody)) {
                return null;
            }

            $message = ChMessage::create([
                'from_id' => $fromId,
                'to_id' => $toId,
                'body' => $sanitizedBody,
                'seen' => false,
            ]);

            // Eager load user relationship (only needed fields)
            $message->load('fromUser:user_id,name,email,role');

            return $message;
        } catch (\Exception $e) {
            Log::error('ChatService::createMessage error', [
                'error' => $e->getMessage(),
                'from_id' => $fromId,
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Get message by ID with user relationship
     */
    public function getMessageById(string $messageId): ?ChMessage
    {
        return ChMessage::with('fromUser:user_id,name,email,role')
            ->find($messageId);
    }

    /**
     * Format message timestamp for display
     */
    public function formatTimestamp($timestamp): string
    {
        if (!$timestamp) {
            return '';
        }

        $now = now();
        $messageTime = is_string($timestamp) ? \Carbon\Carbon::parse($timestamp) : $timestamp;

        // Today - show time only
        if ($messageTime->isToday()) {
            return $messageTime->format('H:i');
        }

        // Yesterday
        if ($messageTime->isYesterday()) {
            return 'Yesterday ' . $messageTime->format('H:i');
        }

        // This week - show day and time
        if ($messageTime->isCurrentWeek()) {
            return $messageTime->format('D H:i');
        }

        // Older - show date and time
        return $messageTime->format('M d, H:i');
    }

    /**
     * Check if user can send message (rate limiting)
     */
    public function canSendMessage(int $userId, int $maxMessagesPerMinute = 10): bool
    {
        $oneMinuteAgo = now()->subMinute();
        
        $recentMessages = ChMessage::where('from_id', $userId)
            ->where('created_at', '>=', $oneMinuteAgo)
            ->count();

        return $recentMessages < $maxMessagesPerMinute;
    }
}
