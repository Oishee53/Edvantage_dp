<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_live_sessions', function (Blueprint $table) {
            $table->string('daily_room_name')->nullable()->after('status');
            $table->string('daily_room_url')->nullable()->after('daily_room_name');
        });
    }

    public function down(): void
    {
        Schema::table('course_live_sessions', function (Blueprint $table) {
            $table->dropColumn(['daily_room_name', 'daily_room_url']);
        });
    }
};