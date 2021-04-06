<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerifyStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verify_states', function (Blueprint $table) {
            //  $table->id();
             // $table->timestamps();
             $table->integer('id')->unique()->unsigned();
             $table->string('verify_state',99);
          });
          Schema::connection('mysql')->table('verify_states', function (Blueprint $table) {
          $table->foreign('id')->references('verify_state')->on('files');
               
  
          });
      }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verify_states');
    }
}
