<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->integer('id_ac')->unsigned();  
            $table->integer('id_user')->unsigned(); 
            $table->integer('id_status')->unsigned();        
            $table->integer('type');                        
            $table->timestamp();

            $table->foreign('id_ac')->references('id')->on('users');  
            $table->foreign('id_user')->references('id')->on('users');  
            $table->foreign('id_status')->references('id_status')->on('statuses');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notices');
    }
}

