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
        Schema::create('daily_programs', function (Blueprint $table) {
            $table->increments('id');
            /*
            $table->foreignId(column:'trip_id')->constrained()->cascadeOnDelete(); 
            $table->foreignId(column:'date_day_id')->constrained()->cascadeOnDelete(); 
            $table->foreignId(column:'timing_id')->constrained()->cascadeOnDelete(); 
            $table->foreignId(column:'place_id')->constrained()->cascadeOnDelete(); 
            $table->foreignId(column:'addition_id')->constrained()->cascadeOnDelete(); 
            //$table->foreignId(column:'نشاط-id')->constrained()->cascadeOnDelete();*/
            $table->integer('trip_id')->unsigned();
            $table->integer('date_day_id')->unsigned();
            $table->integer('timing_id')->unsigned();
            $table->integer('place_id')->unsigned();
            $table->integer('activity-id')->unsigned();
            $table->integer('addition_id')->unsigned();
            // $table->integer('نشاط_id')->unsigned();
            //$table->unsignedBigInteger(column:'user-id');
            //$table->foreign(columns:'user-id')->references(columns:'id')->on(table:'user');
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
        Schema::dropIfExists('daily_programs');
    }
};
