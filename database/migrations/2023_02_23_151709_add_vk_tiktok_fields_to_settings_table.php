<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('vk')->nullable();
            $table->string('tiktok')->nullable();
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
