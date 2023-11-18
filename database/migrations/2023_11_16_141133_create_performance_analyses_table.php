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
        Schema::create('performance_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->nullable()->constrained();
            $table->foreignId('session_id')->nullable()->constrained();
            $table->foreignId('player_profile_id')->constrained();
            $table->text('metrics');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_analyses');
    }
};
