<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_files', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->bigIncrements('id');
            $table->unsignedBigInteger('model_id');
            $table->string('name', 99);
            $table->string('path', 99);
            $table->string('output_path', 99);
            $table->date('uploaded_date');
            $table->unsignedBigInteger('state');
            $table->string('type', 99);
 
           // $table->timestamps();
        });
        Schema::connection('mysql')->table('training_files', function (Blueprint $table) {
        $table->foreign('model_id')->references('id')->on('model_tbls');
        $table->foreign('state')->references('id')->on('training_states');
         });
       
     }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_files');
    }
}
