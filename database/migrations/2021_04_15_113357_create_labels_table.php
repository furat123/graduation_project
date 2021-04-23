<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) {
           
            
             $table->id('id')->unique()->unsigned();
             $table->unsignedBigInteger('model_id');
             $table->string('label',99); 
             $table->string('color',99);

            });
             Schema::connection('mysql')->table('labels', function (Blueprint $table) {
                $table->foreign('model_id')->references('id')->on('model_tbls');
             });
             
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labels');
    }
}
