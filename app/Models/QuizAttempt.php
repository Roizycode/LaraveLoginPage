<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'started_at',
        'completed_at',
        'status',
        'score',
        'total_points',
        'percentage',
        'time_spent',
        'questions_answered',
        'correct_answers',
        'incorrect_answers',
        'answers',
        'metadata',
        'ip_address',
        'user_agent',
        'is_cheating_detected',
        'cheating_notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'answers' => 'array',
        'metadata' => 'array',
        'is_cheating_detected' => 'boolean',
    ];

    /**
     * Get the user who made this attempt
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the quiz this attempt is for
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get all responses for this attempt
     */
    public function responses(): HasMany
    {
        return $this->hasMany(QuestionResponse::class, 'attempt_id');
    }

    /**
     * Check if attempt is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if attempt is in progress
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if attempt is abandoned
     */
    public function isAbandoned(): bool
    {
        return $this->status === 'abandoned';
    }

    /**
     * Check if attempt timed out
     */
    public function isTimeout(): bool
    {
        return $this->status === 'timeout';
    }

    /**
     * Get time remaining in seconds
     */
    public function getTimeRemaining(): ?int
    {
        if (!$this->quiz->time_limit || $this->isCompleted()) {
            return null;
        }

        $timeLimit = $this->quiz->time_limit * 60; // Convert to seconds
        $elapsed = $this->started_at->diffInSeconds(now());
        $remaining = $timeLimit - $elapsed;

        return max(0, $remaining);
    }

    /**
     * Check if attempt has time remaining
     */
    public function hasTimeRemaining(): bool
    {
        $remaining = $this->getTimeRemaining();
        return $remaining !== null && $remaining > 0;
    }

    /**
     * Complete the attempt
     */
    public function complete(): bool
    {
        if ($this->isCompleted()) {
            return false;
        }

        $this->status = 'completed';
        $this->completed_at = now();
        
        // Calculate time spent
        if ($this->started_at) {
            $this->time_spent = $this->started_at->diffInSeconds($this->completed_at);
        }

        // Calculate final score
        $this->calculateFinalScore();

        return $this->save();
    }

    /**
     * Abandon the attempt
     */
    public function abandon(): bool
    {
        if ($this->isCompleted()) {
            return false;
        }

        $this->status = 'abandoned';
        $this->completed_at = now();
        
        if ($this->started_at) {
            $this->time_spent = $this->started_at->diffInSeconds($this->completed_at);
        }

        return $this->save();
    }

    /**
     * Mark as timeout
     */
    public function markAsTimeout(): bool
    {
        if ($this->isCompleted()) {
            return false;
        }

        $this->status = 'timeout';
        $this->completed_at = now();
        
        if ($this->started_at) {
            $this->time_spent = $this->started_at->diffInSeconds($this->completed_at);
        }

        return $this->save();
    }

    /**
     * Calculate final score
     */
    public function calculateFinalScore(): void
    {
        $responses = $this->responses()->get();
        
        $this->correct_answers = $responses->where('is_correct', true)->count();
        $this->incorrect_answers = $responses->where('is_correct', false)->count();
        $this->questions_answered = $responses->count();
        $this->score = $responses->sum('points_earned');
        $this->total_points = $this->quiz->total_points;
        
        if ($this->total_points > 0) {
            $this->percentage = round(($this->score / $this->total_points) * 100, 2);
        } else {
            $this->percentage = 0;
        }
    }

    /**
     * Get attempt grade
     */
    public function getGrade(): string
    {
        if ($this->percentage >= 90) return 'A+';
        if ($this->percentage >= 80) return 'A';
        if ($this->percentage >= 70) return 'B+';
        if ($this->percentage >= 60) return 'B';
        if ($this->percentage >= 50) return 'C+';
        if ($this->percentage >= 40) return 'C';
        if ($this->percentage >= 30) return 'D';
        return 'F';
    }

    /**
     * Get attempt performance level
     */
    public function getPerformanceLevel(): string
    {
        if ($this->percentage >= 80) return 'Excellent';
        if ($this->percentage >= 60) return 'Good';
        if ($this->percentage >= 40) return 'Average';
        return 'Needs Improvement';
    }

    /**
     * Get time spent in human readable format
     */
    public function getTimeSpentFormatted(): string
    {
        if (!$this->time_spent) {
            return 'N/A';
        }

        $hours = floor($this->time_spent / 3600);
        $minutes = floor(($this->time_spent % 3600) / 60);
        $seconds = $this->time_spent % 60;

        if ($hours > 0) {
            return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
        } else {
            return sprintf('%d:%02d', $minutes, $seconds);
        }
    }

    /**
     * Scope for completed attempts
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for attempts by user
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for attempts by quiz
     */
    public function scopeByQuiz($query, int $quizId)
    {
        return $query->where('quiz_id', $quizId);
    }
}