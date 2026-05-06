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
        Schema::create('deteksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kandang_id')->constrained()->cascadeOnDelete();
            $table->foreignId('device_id')->constrained()->cascadeOnDelete();
            $table->json('objects')->nullable();
            $table->float('confidence')->nullable();
            $table->boolean('is_valid')->default(false); //
            $table->string('image')->nullable();
            $table->json('boxes')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deteksis');
    }
};
