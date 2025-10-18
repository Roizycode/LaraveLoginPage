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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'instructor', 'student'])->default('student')->after('email_verified_at');
            $table->string('avatar')->nullable()->after('role');
            $table->json('settings')->nullable()->after('avatar');
            $table->timestamp('last_login_at')->nullable()->after('settings');
            $table->boolean('is_active')->default(true)->after('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'avatar', 'settings', 'last_login_at', 'is_active']);
        });
    }
};