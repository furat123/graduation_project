<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 99)->unique();
            $table->date('created_date');
            $table->date('laset_use_date');
            $table->string('owner')->unique();
            $table->boolean('public_status');
         //   $table->>>>>('picture');
            $table->integer('number_of_feature')->unsigned();
            $table->integer('number_of_using')->unsigned();
            $table->integer('status_id')->unique()->unsigned();
            $table->engine = 'InnoDB';

         //   $table->foreign('owner')->references('name')->on('all_users');

        });
           Schema::connection('mysql')->table('models', function (Blueprint $table) {
          $table->foreign('owner')->references('name')->on('all_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('models');
    }
}
