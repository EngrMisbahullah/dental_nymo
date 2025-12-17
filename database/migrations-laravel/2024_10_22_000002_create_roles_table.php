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
        Schema::create('roles', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->integer('hierarchy_level')->default(3);
            $table->boolean('is_staff')->default(true);
            $table->boolean('is_provider')->default(false);
            $table->boolean('is_external')->default(false);
            $table->string('color', 7)->default('#6B7280');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
