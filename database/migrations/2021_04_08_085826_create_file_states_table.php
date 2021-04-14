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
            // $table->id();
            // $table->timestamps();
            $table->bigInteger('id')->unique()->unsigned();
            $table->string('state',99);
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
