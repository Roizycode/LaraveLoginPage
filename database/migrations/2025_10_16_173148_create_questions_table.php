<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->nullable()->constrained('quizzes')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('type', [
                'multiple_choice_single',
                'multiple_choice_multiple',
                'true_false',
                'fill_blank',
                'short_answer',
                'essay',
                'matching',
                'ordering',
                'image_question',
                'audio_question',
                'video_question'
            ]);
            $table->text('question_text');
            $table->json('options')->nullable(); // For multiple choice, matching, etc.
            $table->json('correct_answer'); // Store correct answers as JSON
            $table->text('explanation')->nullable();
            $table->integer('points')->default(1);
            $table->integer('difficulty_level')->default(1); // 1-5 scale
            $table->integer('time_limit')->nullable(); // in seconds
            $table->boolean('allow_partial_credit')->default(false);
            $table->boolean('negative_marking')->default(false);
            $table->decimal('negative_points', 3, 2)->default(0.25); // Points to deduct for wrong answer
            $table->json('media_files')->nullable(); // Store image, audio, video file paths
            $table->json('hints')->nullable(); // Store hints as JSON array
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['quiz_id', 'type']);
            $table->index(['category_id', 'is_active']);
            $table->index(['created_by', 'type']);
            $table->index('difficulty_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};