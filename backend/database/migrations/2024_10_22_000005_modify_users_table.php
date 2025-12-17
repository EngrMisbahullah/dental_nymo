<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('practice_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('phone', 20)->nullable();
            $table->string('avatar_url', 500)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_locked')->default(false);
            $table->integer('failed_login_attempts')->default(0);
            $table->timestamp('last_login_at')->nullable();

            $table->index(['practice_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['practice_id']);
            $table->dropColumn([
                'practice_id',
                'phone',
                'avatar_url',
                'is_active',
                'is_locked',
                'failed_login_attempts',
                'last_login_at'
            ]);
        });
    }
};