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
        Schema::create('quiz_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->boolean('allow_question_review')->default(true);
            $table->boolean('show_question_numbers')->default(true);
            $table->boolean('show_progress_bar')->default(true);
            $table->boolean('allow_question_skipping')->default(true);
            $table->boolean('auto_submit_on_timeout')->default(true);
            $table->boolean('prevent_copy_paste')->default(false);
            $table->boolean('prevent_right_click')->default(false);
            $table->boolean('prevent_tab_switching')->default(false);
            $table->boolean('require_webcam')->default(false);
            $table->boolean('require_microphone')->default(false);
            $table->integer('warning_before_timeout')->default(5); // minutes
            $table->boolean('send_completion_email')->default(true);
            $table->boolean('send_results_email')->default(true);
            $table->json('custom_css')->nullable();
            $table->json('custom_js')->nullable();
            $table->timestamps();
            
            $table->unique('quiz_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_settings');
    }
};