<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_tbls', function (Blueprint $table) {
            //  $table->id();
             // $table->timestamps();
  
              $table->id('id');
              $table->string('name', 99)->unique();
              $table->string('picture', 99)->unique();
              $table->date('created_date');
              $table->date('last_use_date');
              $table->unsignedBigInteger('owner_id');
              $table->boolean('public_state');
              $table->integer('number_of_using')->unsigned();
              $table->unsignedBigInteger('state_id');
              $table->float('progress',99);
              
              //$table->timestamps();
            //  $table->id();
             
          });
          
          Schema::connection('mysql')->table('model_tbls', function (Blueprint $table) {
            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('state_id')->references('id')->on('model_states');
           });
      }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_tbls');
    }
}
