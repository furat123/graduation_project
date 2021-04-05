<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_states', function (Blueprint $table) {

            $table->integer('id')->unique()->unsigned();
            $table->string('status',99);
            $table->engine ='InnoDB';
            //$table->timestamps();
        });

        Schema::connection('mysql')->table('file_states', function (Blueprint $table) {
        $table->foreign('id')->references('verify_status')->on('files'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_states');
    }
}
