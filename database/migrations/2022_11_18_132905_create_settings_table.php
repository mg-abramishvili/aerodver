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
            $table->string('tiktok')->nullable();
            $table->string('dzen')->nullable();
            $table->string('vk')->nullable();
            $table->longText('header')->nullable();
            $table->longText('footer')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('energoaudit_gallery')->nullable();
            $table->longText('energoaudit_text')->nullable();
            $table->string('energoaudit_icon')->nullable();
            $table->text('energoarenda_gallery')->nullable();
            $table->longText('energoarenda_text')->nullable();
            $table->string('energoarenda_icon')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
