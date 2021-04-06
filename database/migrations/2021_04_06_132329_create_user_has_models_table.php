<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHasModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_models', function (Blueprint $table) {
            //$table->id();
            //$table->timestamps();
            $table->bigIncrements('id');
            //$table->integer('user_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('model_id');
            $table->boolean('accept');
            $table->date('end_date');

            $table->engine = 'InnoDB';
            //$table->timestamps();
        });
        Schema::connection('mysql')->table('user_has_models', function (Blueprint $table) {
           $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('user_has_models');
    }
}
