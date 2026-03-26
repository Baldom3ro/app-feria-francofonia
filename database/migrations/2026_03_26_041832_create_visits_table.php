<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('standId');
            $table->unsignedBigInteger('participantId');
            $table->timestamps();
            
            // Foreign keys usually but might depend on how Laravel generates relations.
            // Simplified here per user spec.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
