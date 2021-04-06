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

            $table->bigIncrements('id');
            $table->string('name', 99)->unique();
            $table->string('picture', 99)->unique();
            $table->date('created_date');
            $table->date('last_use_date');
            $table->string('owner')->unique();
            $table->boolean('public_state');
            $table->integer('number_of_feature')->unsigned();
            $table->integer('number_of_using')->unsigned();
            $table->integer('state_id')->unique()->unsigned();
            //$table->timestamps();
          //  $table->id();
           
        });
        
        Schema::connection('mysql')->table('model_tbls', function (Blueprint $table) {
        $table->foreign('owner')->references('name')->on('users');
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
