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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->enum('access_type', ['public', 'private', 'password_protected', 'invitation_only'])->default('public');
            $table->string('password')->nullable();
            $table->json('settings')->nullable(); // Store quiz settings like time limits, attempts, etc.
            $table->integer('total_questions')->default(0);
            $table->integer('total_points')->default(0);
            $table->integer('time_limit')->nullable(); // in minutes
            $table->integer('max_attempts')->nullable();
            $table->boolean('randomize_questions')->default(false);
            $table->boolean('randomize_answers')->default(false);
            $table->boolean('show_correct_answers')->default(true);
            $table->boolean('show_results_immediately')->default(true);
            $table->boolean('allow_navigation')->default(true);
            $table->boolean('require_fullscreen')->default(false);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'access_type']);
            $table->index(['instructor_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};