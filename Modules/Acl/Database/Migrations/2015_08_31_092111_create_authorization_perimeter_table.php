<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizationPerimeterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorization_perimeter', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('perimeter_id')->index();
            $table->foreign('perimeter_id')->references('id')->on('perimeters')->onDelete('cascade');
            $table->integer('authorization_id')->index();
            $table->foreign('authorization_id')->references('id')->on('authorizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('authorization_perimeter');
    }
}
