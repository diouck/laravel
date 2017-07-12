<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerimetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perimeters', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('com')->unique();
            $table->string('nom_com');
            $table->string('epci')->nullable();
            $table->string('nom_epci')->nullable();
            $table->string('dep')->nullable();
            $table->string('nom_dep')->nullable();
            $table->timestamps();
        });
        DB::statement("select AddGeometryColumn('','','perimeters','geom',4326,'MULTIPOLYGON',2)");
        DB::statement("CREATE INDEX perimeters_geom_index ON perimeters USING gist (geom)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('perimeters');
    }
}
