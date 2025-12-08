<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ChMessage extends Model
{
    protected $table = 'ch_messages';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id',
        'from_id',
        'to_id',
        'body',
        'attachment',
        'seen',
    ];

    protected $casts = [
        'seen' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the user who sent the message
     */
    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_id', 'user_id');
    }

    /**
     * Get the user who receives the message
     */
    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_id', 'user_id');
    }

    /**
     * Scope for public chat messages
     */
    public function scopePublicChat($query)
    {
        return $query->where('to_id', 0);
    }

    /**
     * Scope for messages from a specific user
     */
    public function scopeFromUser($query, int $userId)
    {
        return $query->where('from_id', $userId);
    }

    /**
     * Scope for recent messages
     */
    public function scopeRecent($query, int $limit = 50)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Get formatted time
     */
    public function getFormattedTimeAttribute(): string
    {
        $now = now();
        $diff = $this->created_at->diffInMinutes($now);

        if ($diff < 1) {
            return '刚刚';
        } elseif ($diff < 60) {
            return $diff . '分钟前';
        } elseif ($this->created_at->isToday()) {
            return $this->created_at->format('H:i');
        } elseif ($this->created_at->isYesterday()) {
            return '昨天 ' . $this->created_at->format('H:i');
        } elseif ($this->created_at->isCurrentYear()) {
            return $this->created_at->format('m-d H:i');
        } else {
            return $this->created_at->format('Y-m-d H:i');
        }
    }
}
