<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Suscriptors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('suscriptors', function (Blueprint $table) {
            $table->string('serie_id');
            $table->unsignedInteger('user_id');
            $table->primary(['user_id','serie_id']);
            $table->foreign('serie_id')->references('id')->on('series')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('suscriptors');
    }
}
