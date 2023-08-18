<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('about_text');
            $table->text('about_text_eng');
            $table->string('video_bg')->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
