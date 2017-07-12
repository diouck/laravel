<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvz2RevisionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avz_2_revisions', function(Blueprint $table)
        {
            $table->increments('id')->index();
            $table->integer('post_id')->nullable();
            $table->integer('user_id');
            $table->integer('perimeter_id')->nullable();
            $table->string('slug',200)->nullable();
            $table->text('title')->nullable();
            $table->string('excerpt',500)->nullable();
            $table->text('content')->nullable();
            $table->string('status',20)->default('public');
            $table->timestamps();
        });

        DB::statement("select AddGeometryColumn('','','avz_2_revisions','point',4326,'MULTIPOINT',2)");
        DB::statement("CREATE INDEX avz_2_revisions_point_index ON avz_2_revisions USING gist (point)");
        DB::statement("select AddGeometryColumn('','','avz_2_revisions','polygon',4326,'MULTIPOLYGON',2)");
        DB::statement("CREATE INDEX avz_2_revisions_polygon_index ON avz_2_revisions USING gist (polygon)");
        DB::statement("select AddGeometryColumn('','','avz_2_revisions','linestring',4326,'MULTILINESTRING',2)");
        DB::statement("CREATE INDEX avz_2_revisions_linestring_index ON avz_2_revisions USING gist (linestring)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('avz_2_revisions');
    }

}
