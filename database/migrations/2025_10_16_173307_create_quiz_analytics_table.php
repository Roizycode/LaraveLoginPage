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
        Schema::create('quiz_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('metric_type'); // 'completion_rate', 'average_score', 'time_spent', etc.
            $table->decimal('value', 10, 2);
            $table->json('metadata')->nullable(); // Additional metric data
            $table->date('recorded_date');
            $table->timestamps();
            
            $table->index(['quiz_id', 'metric_type']);
            $table->index(['user_id', 'metric_type']);
            $table->index('recorded_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_analytics');
    }
};