<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'allow_question_review',
        'show_question_numbers',
        'show_progress_bar',
        'allow_question_skipping',
        'auto_submit_on_timeout',
        'prevent_copy_paste',
        'prevent_right_click',
        'prevent_tab_switching',
        'require_webcam',
        'require_microphone',
        'warning_before_timeout',
        'send_completion_email',
        'send_results_email',
        'custom_css',
        'custom_js',
    ];

    protected $casts = [
        'allow_question_review' => 'boolean',
        'show_question_numbers' => 'boolean',
        'show_progress_bar' => 'boolean',
        'allow_question_skipping' => 'boolean',
        'auto_submit_on_timeout' => 'boolean',
        'prevent_copy_paste' => 'boolean',
        'prevent_right_click' => 'boolean',
        'prevent_tab_switching' => 'boolean',
        'require_webcam' => 'boolean',
        'require_microphone' => 'boolean',
        'send_completion_email' => 'boolean',
        'send_results_email' => 'boolean',
        'custom_css' => 'array',
        'custom_js' => 'array',
    ];

    /**
     * Get the quiz this setting belongs to
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get default settings
     */
    public static function getDefaults(): array
    {
        return [
            'allow_question_review' => true,
            'show_question_numbers' => true,
            'show_progress_bar' => true,
            'allow_question_skipping' => true,
            'auto_submit_on_timeout' => true,
            'prevent_copy_paste' => false,
            'prevent_right_click' => false,
            'prevent_tab_switching' => false,
            'require_webcam' => false,
            'require_microphone' => false,
            'warning_before_timeout' => 5,
            'send_completion_email' => true,
            'send_results_email' => true,
        ];
    }

    /**
     * Check if proctoring is enabled
     */
    public function hasProctoring(): bool
    {
        return $this->prevent_copy_paste || 
               $this->prevent_right_click || 
               $this->prevent_tab_switching || 
               $this->require_webcam || 
               $this->require_microphone;
    }

    /**
     * Get proctoring settings
     */
    public function getProctoringSettings(): array
    {
        return [
            'prevent_copy_paste' => $this->prevent_copy_paste,
            'prevent_right_click' => $this->prevent_right_click,
            'prevent_tab_switching' => $this->prevent_tab_switching,
            'require_webcam' => $this->require_webcam,
            'require_microphone' => $this->require_microphone,
        ];
    }

    /**
     * Get UI settings
     */
    public function getUISettings(): array
    {
        return [
            'allow_question_review' => $this->allow_question_review,
            'show_question_numbers' => $this->show_question_numbers,
            'show_progress_bar' => $this->show_progress_bar,
            'allow_question_skipping' => $this->allow_question_skipping,
        ];
    }

    /**
     * Get notification settings
     */
    public function getNotificationSettings(): array
    {
        return [
            'send_completion_email' => $this->send_completion_email,
            'send_results_email' => $this->send_results_email,
        ];
    }
}