<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('main_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_eng');
            $table->string('subtitle')->nullable();
            $table->string('subtitle_eng')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('main_banners');
    }
};
