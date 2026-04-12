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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kandang_id')->constrained()->cascadeOnDelete();
            $table->string('device_id')->unique(); 
            $table->string('device_name')->nullable();
            $table->enum('device_type', ['gateway', 'sensor', 'camera', 'actuator']);
            $table->string('profile_image')->nullable();
            $table->enum('status', ['online', 'offline'])->default('offline');
            $table->enum('door_status', ['TERBUKA', 'TERTUTUP'])->nullable();
            $table->enum('light_status', ['HIDUP', 'MATI'])->nullable();
            $table->timestamp('last_updated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
