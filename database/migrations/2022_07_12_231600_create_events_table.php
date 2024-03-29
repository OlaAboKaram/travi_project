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
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
           
            $table->string('name');
            $table->string('description');
            $table->string('timing');
            $table->string('image');
            $table->integer('dateday_id')->unsigned()->nullable();
            $table->foreign('dateday_id')->references('id')->on('datedays')->nullOnDelete()->onDelete('cascade');
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
        Schema::dropIfExists('events');
    }
};




