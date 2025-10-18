<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'instructor_id',
        'category_id',
        'status',
        'access_type',
        'password',
        'settings',
        'total_questions',
        'total_points',
        'time_limit',
        'max_attempts',
        'randomize_questions',
        'randomize_answers',
        'show_correct_answers',
        'show_results_immediately',
        'allow_navigation',
        'require_fullscreen',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'settings' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'randomize_questions' => 'boolean',
        'randomize_answers' => 'boolean',
        'show_correct_answers' => 'boolean',
        'show_results_immediately' => 'boolean',
        'allow_navigation' => 'boolean',
        'require_fullscreen' => 'boolean',
    ];

    /**
     * Get the instructor who created this quiz
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get the category this quiz belongs to
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all questions for this quiz
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get all attempts for this quiz
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Get quiz settings
     */
    public function settings(): HasMany
    {
        return $this->hasMany(QuizSetting::class);
    }

    /**
     * Get the main quiz setting
     */
    public function quizSetting(): HasMany
    {
        return $this->hasMany(QuizSetting::class);
    }

    /**
     * Check if quiz is currently active
     */
    public function isActive(): bool
    {
        $now = Carbon::now();
        
        if ($this->status !== 'published') {
            return false;
        }

        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }

        return true;
    }

    /**
     * Check if quiz is accessible by user
     */
    public function isAccessibleBy(User $user): bool
    {
        // Admin and instructor can always access
        if ($user->isAdmin() || $user->isInstructor()) {
            return true;
        }

        // Check if quiz is active
        if (!$this->isActive()) {
            return false;
        }

        // Check access type
        switch ($this->access_type) {
            case 'public':
                return true;
            case 'private':
                return false; // Would need additional logic for private access
            case 'password_protected':
                return true; // Password check would be done at controller level
            case 'invitation_only':
                return false; // Would need additional logic for invitations
            default:
                return false;
        }
    }

    /**
     * Get quiz statistics
     */
    public function getStats(): array
    {
        $attempts = $this->attempts()->where('status', 'completed')->get();
        
        return [
            'total_attempts' => $attempts->count(),
            'unique_attempts' => $attempts->pluck('user_id')->unique()->count(),
            'average_score' => $attempts->avg('percentage') ?? 0,
            'completion_rate' => $attempts->count() > 0 ? 
                ($attempts->where('status', 'completed')->count() / $attempts->count()) * 100 : 0,
            'average_time' => $attempts->avg('time_spent') ?? 0,
        ];
    }

    /**
     * Get questions in random order if enabled
     */
    public function getQuestionsInOrder()
    {
        $query = $this->questions()->where('is_active', true);
        
        if ($this->randomize_questions) {
            $query->inRandomOrder();
        } else {
            $query->orderBy('id');
        }
        
        return $query->get();
    }

    /**
     * Check if user can attempt this quiz
     */
    public function canUserAttempt(User $user): array
    {
        $errors = [];

        if (!$this->isAccessibleBy($user)) {
            $errors[] = 'Quiz is not accessible';
        }

        if ($this->max_attempts) {
            $userAttempts = $this->attempts()->where('user_id', $user->id)->count();
            if ($userAttempts >= $this->max_attempts) {
                $errors[] = 'Maximum attempts exceeded';
            }
        }

        return $errors;
    }
}