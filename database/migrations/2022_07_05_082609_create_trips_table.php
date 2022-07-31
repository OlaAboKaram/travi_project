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
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('state_id')->unsigned()->nullable();
        $table->integer('governement_id')->unsigned()->nullable();
         $table->integer('area_id')->unsigned()->nullable();
         $table->integer('user_id')->unsigned()->nullable();
          $table->integer('dailyprogram_id')->unsigned();          
        //    $table->unsignedBigInteger(column:'state-id');
        //  $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
          //  $table->foreignId(column:'state-id')->constrained()->cascadeOnDelete();   
           // $table->foreignId(column:'governorate-id')->constrained()->cascadeOnDelete(); 
//$table->foreignId(column:'type-id')->constrained()->cascadeOnDelete();  
            $table->string('name');
            $table->enum('age',['10-20','20-30','30-40','40-50','50-60','60-70'])->default('20-30');
           $table->enum('type',['family','شباب','جامعية','مدرسة ','بنات'])->default('family');
            $table->double('price');
            
            $table->date('start_date');
            $table->date('expiry_date');
           
           $table->date('start_trip');
           $table->date('end_trip');

           $table->integer('rest');
           $table->integer('total');
            $table->string('image')->nullable();
           $table->integer('reiteration');
          
            $table->enum('coutinent',['africa','antarctica','asia','australia','europe','north america','south america'])->default('africa');
           
            $table->string('name_team');
            $table->string('about');
           // وريت ضل نشاط ونوع ويوزر برنامج 
            //$table->unsignedBigInteger(column:'user-id');
            //$table->foreign(columns:'user-id')->references(columns:'id')->on(table:'user');
            //$table->foreignId(column:'users-id')->constrained()->cascadeOnDelete();            // $table->foreignId(column:'نشاط-id')->constrained()->cascadeOnDelete(); اني بدي جيبو اكثر من واحد
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
        Schema::dropIfExists('trips');
    }
};
