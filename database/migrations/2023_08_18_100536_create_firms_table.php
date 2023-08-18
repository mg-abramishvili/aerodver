<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('firms', function (Blueprint $table) {
            $table->id();
            $table->integer('city_id');
            $table->string('name');
            $table->string('name_eng');
            $table->string('address')->nullable();
            $table->string('tel')->nullable();
            $table->string('whatsapp')->nullable();
            $table->integer('price')->nullable();
            $table->text('gallery')->nullable();
            $table->text('videogallery')->nullable();
            $table->text('description')->nullable();
            $table->text('description2')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('firms');
    }
};
