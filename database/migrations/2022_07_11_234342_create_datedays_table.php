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
        
            $table->enum('name',['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'])->default('Sunday');
            $table->string('description');
            $table->dateTime('day');
            $table->integer('dailyprogram_id')->unsigned()->nullable();
            $table->foreign('dailyprogram_id')->references('id')->on('dailyprograms')->nullOnDelete()->onDelete('cascade');
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
