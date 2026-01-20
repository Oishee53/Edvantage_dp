<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('final_exam_submissions', function (Blueprint $table) {
        $table->string('webcam_playback_id')->nullable();
    });
}

public function down()
{
    Schema::table('final_exam_submissions', function (Blueprint $table) {
        $table->dropColumn('webcam_playback_id');
    });
}
};
