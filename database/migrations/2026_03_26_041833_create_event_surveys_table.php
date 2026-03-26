<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participantId');
            $table->tinyInteger('q1')->nullable();
            $table->tinyInteger('q2')->nullable();
            $table->tinyInteger('q3')->nullable();
            $table->tinyInteger('q4')->nullable();
            $table->tinyInteger('q5')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_surveys');
    }
};
