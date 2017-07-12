<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvz1PostmetasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avz_1_postmetas', function(Blueprint $table)
        {
            $table->increments('id')->index();
            $table->integer('post_id')->index();
            $table->string('metakey',255);
            $table->text('metavalue');
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
        Schema::drop('avz_1_postmetas');
    }

}
