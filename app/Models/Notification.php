<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user this notification belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(): bool
    {
        if ($this->is_read) {
            return true;
        }

        $this->is_read = true;
        $this->read_at = now();
        
        return $this->save();
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread(): bool
    {
        if (!$this->is_read) {
            return true;
        }

        $this->is_read = false;
        $this->read_at = null;
        
        return $this->save();
    }

    /**
     * Check if notification is read
     */
    public function isRead(): bool
    {
        return $this->is_read;
    }

    /**
     * Get notification type display name
     */
    public function getTypeDisplayAttribute(): string
    {
        return match($this->type) {
            'quiz_created' => 'Quiz Created',
            'quiz_completed' => 'Quiz Completed',
            'quiz_graded' => 'Quiz Graded',
            'announcement' => 'Announcement',
            'system' => 'System Notification',
            'reminder' => 'Reminder',
            'invitation' => 'Invitation',
            default => 'Notification',
        };
    }

    /**
     * Get notification icon
     */
    public function getIconAttribute(): string
    {
        return match($this->type) {
            'quiz_created' => 'fas fa-plus-circle',
            'quiz_completed' => 'fas fa-check-circle',
            'quiz_graded' => 'fas fa-star',
            'announcement' => 'fas fa-bullhorn',
            'system' => 'fas fa-cog',
            'reminder' => 'fas fa-clock',
            'invitation' => 'fas fa-envelope',
            default => 'fas fa-bell',
        };
    }

    /**
     * Get notification color
     */
    public function getColorAttribute(): string
    {
        return match($this->type) {
            'quiz_created' => 'text-blue-600',
            'quiz_completed' => 'text-green-600',
            'quiz_graded' => 'text-yellow-600',
            'announcement' => 'text-purple-600',
            'system' => 'text-gray-600',
            'reminder' => 'text-orange-600',
            'invitation' => 'text-indigo-600',
            default => 'text-gray-600',
        };
    }

    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for read notifications
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope for notifications by type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for recent notifications
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}