<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'category_id',
        'created_by',
        'type',
        'question_text',
        'options',
        'correct_answer',
        'explanation',
        'points',
        'difficulty_level',
        'time_limit',
        'allow_partial_credit',
        'negative_marking',
        'negative_points',
        'media_files',
        'hints',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'correct_answer' => 'array',
        'media_files' => 'array',
        'hints' => 'array',
        'allow_partial_credit' => 'boolean',
        'negative_marking' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the quiz this question belongs to
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the category this question belongs to
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user who created this question
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all responses to this question
     */
    public function responses(): HasMany
    {
        return $this->hasMany(QuestionResponse::class);
    }

    /**
     * Get tags for this question
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'question_tags');
    }

    /**
     * Get question type display name
     */
    public function getTypeDisplayAttribute(): string
    {
        return match($this->type) {
            'multiple_choice_single' => 'Multiple Choice (Single)',
            'multiple_choice_multiple' => 'Multiple Choice (Multiple)',
            'true_false' => 'True/False',
            'fill_blank' => 'Fill in the Blank',
            'short_answer' => 'Short Answer',
            'essay' => 'Essay',
            'matching' => 'Matching',
            'ordering' => 'Ordering/Sequence',
            'image_question' => 'Image Question',
            'audio_question' => 'Audio Question',
            'video_question' => 'Video Question',
            default => 'Unknown Type',
        };
    }

    /**
     * Get difficulty level display name
     */
    public function getDifficultyDisplayAttribute(): string
    {
        return match($this->difficulty_level) {
            1 => 'Very Easy',
            2 => 'Easy',
            3 => 'Medium',
            4 => 'Hard',
            5 => 'Very Hard',
            default => 'Unknown',
        };
    }

    /**
     * Check if question is multiple choice
     */
    public function isMultipleChoice(): bool
    {
        return in_array($this->type, ['multiple_choice_single', 'multiple_choice_multiple']);
    }

    /**
     * Check if question is subjective (requires manual grading)
     */
    public function isSubjective(): bool
    {
        return in_array($this->type, ['short_answer', 'essay']);
    }

    /**
     * Get options in random order if enabled
     */
    public function getOptionsInOrder(): array
    {
        $options = $this->options ?? [];
        
        if ($this->quiz && $this->quiz->randomize_answers) {
            shuffle($options);
        }
        
        return $options;
    }

    /**
     * Calculate score for a given answer
     */
    public function calculateScore(string $answer): array
    {
        $isCorrect = false;
        $pointsEarned = 0;
        
        switch ($this->type) {
            case 'multiple_choice_single':
            case 'true_false':
                $isCorrect = $answer === ($this->correct_answer[0] ?? '');
                $pointsEarned = $isCorrect ? $this->points : 0;
                break;
                
            case 'multiple_choice_multiple':
                $userAnswers = json_decode($answer, true) ?? [];
                $correctAnswers = $this->correct_answer ?? [];
                $isCorrect = empty(array_diff($userAnswers, $correctAnswers)) && 
                           empty(array_diff($correctAnswers, $userAnswers));
                $pointsEarned = $isCorrect ? $this->points : 0;
                break;
                
            case 'fill_blank':
                $userAnswer = strtolower(trim($answer));
                $correctAnswers = array_map('strtolower', $this->correct_answer ?? []);
                $isCorrect = in_array($userAnswer, $correctAnswers);
                $pointsEarned = $isCorrect ? $this->points : 0;
                break;
                
            case 'short_answer':
            case 'essay':
                // These require manual grading
                $isCorrect = false;
                $pointsEarned = 0;
                break;
                
            default:
                $isCorrect = false;
                $pointsEarned = 0;
        }
        
        // Apply negative marking if enabled
        if (!$isCorrect && $this->negative_marking) {
            $pointsEarned = -$this->negative_points;
        }
        
        return [
            'is_correct' => $isCorrect,
            'points_earned' => $pointsEarned,
        ];
    }

    /**
     * Get question statistics
     */
    public function getStats(): array
    {
        $responses = $this->responses()->get();
        
        return [
            'total_attempts' => $responses->count(),
            'correct_attempts' => $responses->where('is_correct', true)->count(),
            'accuracy_rate' => $responses->count() > 0 ? 
                ($responses->where('is_correct', true)->count() / $responses->count()) * 100 : 0,
            'average_time' => $responses->avg('time_spent') ?? 0,
        ];
    }

    /**
     * Scope for active questions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for questions by type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for questions by difficulty
     */
    public function scopeByDifficulty($query, int $level)
    {
        return $query->where('difficulty_level', $level);
    }
}