<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
           // $table->id();
           // $table->timestamps();
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_model_id');
            $table->string('name', 99);
            $table->string('path', 99);
            $table->string('output_path', 99);
            $table->date('uploaded_date');
           // $table->integer('user_model_id')->unsigned();
            $table->unsignedBigInteger('verify_state');;//verify of picture
            $table->unsignedBigInteger('state_id');
            $table->integer('accuracy');
        });
        Schema::connection('mysql')->table('files', function (Blueprint $table) {
            $table->foreign('user_model_id')->references('id')->on('user_has_models');
            $table->foreign('state_id')->references('id')->on('file_states');
            $table->foreign('verify_state')->references('id')->on('verify_states');
             });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
