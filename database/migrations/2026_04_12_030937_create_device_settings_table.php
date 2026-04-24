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
        Schema::create('device_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kandang_id')->unique()->constrained()->cascadeOnDelete();
            $table->time('timer_open')->default('06:00:00');
            $table->time('timer_close')->default('18:00:00');
            $table->boolean('is_set')->default(false);
            $table->boolean('auto_mode')->default(true);
            $table->boolean('notification_active')->default(true);
            $table->decimal('temp_threshold', 5, 2)->default(30.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_settings');
    }
};
