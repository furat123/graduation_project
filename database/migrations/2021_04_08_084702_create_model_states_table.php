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
            // $table->id();
            // $table->timestamps();
            $table->bigInteger('id')->unique()->unsigned();
            $table->string('state',99);
            $table->float('progress',99);
            $table->engine = 'InnoDB';
            
           // $table->timestamps();
        });
 
      //  Schema::connection('mysql')->table('model_states', function (Blueprint $table) {
        //    $table->foreign('id')->references('state_id')->on('model_tbls');
       // });
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
