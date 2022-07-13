<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datedays', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dailyprogram_id')->unsigned();
            $table->enum('name',['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'])->default('Sunday');
            $table->string('description');
            $table->dateTime('day');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datedays');
    }
};
