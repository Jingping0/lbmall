<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public int $fromId;
    public string $fromName;
    public string $fromRole;
    public ?string $messageId;

    /**
     * Create a new event instance.
     */
    public function __construct(string $message, int $fromId, string $fromName, string $fromRole, ?string $messageId = null)
    {
        $this->message = $message;
        $this->fromId = $fromId;
        $this->fromName = $fromName;
        $this->fromRole = $fromRole;
        $this->messageId = $messageId;
    }

    /**
     * Determine if this event should be broadcast.
     */
    public function shouldBroadcast(): bool
    {
        // Only broadcast if Pusher is configured
        return config('broadcasting.default') === 'pusher' 
            && !empty(config('broadcasting.connections.pusher.key'));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('public')
        ];
    }

    public function broadcastAs(): string
    {
        return 'chat';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'from_id' => $this->fromId,
            'from_name' => $this->fromName,
            'from_role' => $this->fromRole,
            'message_id' => $this->messageId,
        ];
    }
}
