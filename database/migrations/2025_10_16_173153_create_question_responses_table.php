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
        Schema::create('question_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('quiz_attempts')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->text('answer')->nullable(); // User's answer
            $table->json('answer_data')->nullable(); // Structured answer data for complex questions
            $table->boolean('is_correct')->default(false);
            $table->decimal('points_earned', 5, 2)->default(0);
            $table->integer('time_spent')->nullable(); // Time spent on this question in seconds
            $table->timestamp('answered_at')->nullable();
            $table->text('feedback')->nullable(); // Instructor feedback for subjective questions
            $table->boolean('is_graded')->default(false);
            $table->foreignId('graded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('graded_at')->nullable();
            $table->timestamps();
            
            $table->index(['attempt_id', 'question_id']);
            $table->index(['question_id', 'is_correct']);
            $table->index('is_graded');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_responses');
    }
};