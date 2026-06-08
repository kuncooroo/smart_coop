<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deteksis', function (Blueprint $table) {
            $table->boolean('trigger_servo')
                  ->default(false)
                  ->after('is_valid');
        });
    }

    public function down(): void
    {
        Schema::table('deteksis', function (Blueprint $table) {
            $table->dropColumn('trigger_servo');
        });
    }
};