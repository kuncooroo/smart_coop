<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('door_timers', function (Blueprint $table) {
            $table->id();
            $table->string('device_id');
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->boolean('enabled')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('door_timers');
    }
};