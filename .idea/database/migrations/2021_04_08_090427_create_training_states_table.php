<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_states', function (Blueprint $table) {
            //$table->id();
            //$table->timestamps();
           $table->bigInteger('id')->unique()->unsigned();
           $table->string('training_state',99);
        });
       
    
    } 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_states');
    }
}
