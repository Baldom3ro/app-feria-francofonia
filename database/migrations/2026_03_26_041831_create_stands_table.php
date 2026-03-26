<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->string('qrToken')->unique();
            $table->unsignedBigInteger('ownerUserId')->nullable();
            $table->integer('totalVisits')->default(0);
            $table->integer('totalSurveys')->default(0);
            $table->decimal('avgRating', 8, 2)->default(0);
            $table->timestamps();
            
            // Note: ownerUserId foreign key will be added later or relies on application logic to avoid circular dependency since users have standId.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stands');
    }
};
