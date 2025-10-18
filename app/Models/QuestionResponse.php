<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'question_id',
        'answer',
        'answer_data',
        'is_correct',
        'points_earned',
        'time_spent',
        'answered_at',
        'feedback',
        'is_graded',
        'graded_by',
        'graded_at',
    ];

    protected $casts = [
        'answer_data' => 'array',
        'answered_at' => 'datetime',
        'graded_at' => 'datetime',
        'is_correct' => 'boolean',
        'is_graded' => 'boolean',
    ];

    /**
     * Get the attempt this response belongs to
     */
    public function attempt(): BelongsTo
    {
        return $this->belongsTo(QuizAttempt::class, 'attempt_id');
    }

    /**
     * Get the question this response is for
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the user who graded this response
     */
    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    /**
     * Check if response is graded
     */
    public function isGraded(): bool
    {
        return $this->is_graded;
    }

    /**
     * Check if response is correct
     */
    public function isCorrect(): bool
    {
        return $this->is_correct;
    }

    /**
     * Get formatted answer for display
     */
    public function getFormattedAnswer(): string
    {
        if ($this->answer_data) {
            return json_encode($this->answer_data, JSON_PRETTY_PRINT);
        }
        
        return $this->answer ?? 'No answer provided';
    }

    /**
     * Get time spent in human readable format
     */
    public function getTimeSpentFormatted(): string
    {
        if (!$this->time_spent) {
            return 'N/A';
        }

        $minutes = floor($this->time_spent / 60);
        $seconds = $this->time_spent % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Scope for graded responses
     */
    public function scopeGraded($query)
    {
        return $query->where('is_graded', true);
    }

    /**
     * Scope for ungraded responses
     */
    public function scopeUngraded($query)
    {
        return $query->where('is_graded', false);
    }

    /**
     * Scope for correct responses
     */
    public function scopeCorrect($query)
    {
        return $query->where('is_correct', true);
    }

    /**
     * Scope for incorrect responses
     */
    public function scopeIncorrect($query)
    {
        return $query->where('is_correct', false);
    }
}