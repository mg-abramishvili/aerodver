<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('name');
            $table->string('name_eng');
            $table->text('description');
            $table->text('description_eng');
            $table->integer('price_rub');
            $table->integer('price_usd');
            $table->integer('order')->default(999);
            $table->text('gallery');
            $table->string('slug')->nullable();
            $table->string('video')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
