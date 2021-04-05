<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_states', function (Blueprint $table) {
            $table->integer('id')->unique()->unsigned();
            $table->string('status',99);
            $table->engine = 'InnoDB';
            
           // $table->timestamps();
        });

        Schema::connection('mysql')->table('model_states', function (Blueprint $table) {
            $table->foreign('id')->references('status_id')->on('models');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_states');
    }
}
