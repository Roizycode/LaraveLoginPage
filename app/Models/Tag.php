<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get questions with this tag
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'question_tags');
    }

    /**
     * Get active questions with this tag
     */
    public function activeQuestions(): BelongsToMany
    {
        return $this->questions()->where('is_active', true);
    }

    /**
     * Get tag usage count
     */
    public function getUsageCount(): int
    {
        return $this->questions()->count();
    }

    /**
     * Get active tag usage count
     */
    public function getActiveUsageCount(): int
    {
        return $this->activeQuestions()->count();
    }

    /**
     * Scope for active tags
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for popular tags
     */
    public function scopePopular($query, int $limit = 10)
    {
        return $query->withCount('questions')
                    ->orderBy('questions_count', 'desc')
                    ->limit($limit);
    }
}