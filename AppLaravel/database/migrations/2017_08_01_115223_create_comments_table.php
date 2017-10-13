<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {            
            $table->integer('id_status')->unsigned();
            $table->integer('id_user')->unsigned();            
            $table->longtext('content');
        
            // $table->timestamp('created')->nullable();
            // $table->timestamp('updated')->nullable();
            $table->timestamps();

            $table->foreign('id_status')->references('id_status')->on('statuses');     
            $table->foreign('id_user')->references('id')->on('users');     

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
