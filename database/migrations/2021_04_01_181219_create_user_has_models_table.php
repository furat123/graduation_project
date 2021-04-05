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
            $table->increments('id', true);
            $table->integer('user_id')->unsigned();
            $table->integer('model_id')->unsigned();
            $table->engine = 'InnoDB';
            //$table->timestamps();
        });
        Schema::connection('mysql')->table('user_has_models', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('all_users');
            $table->foreign('model_id')->references('id')->on('models');
            
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
