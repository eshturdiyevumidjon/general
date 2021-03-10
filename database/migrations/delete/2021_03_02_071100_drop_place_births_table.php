<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPlaceBirthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('water_collecctions', function(Blueprint $table) {
            $table->dropForeign('water_collecctions_birth_place_id_foreign');
        });

        Schema::table('approval_plots', function(Blueprint $table) {
            $table->dropForeign('approval_plots_birth_place_id_foreign');
        });

        Schema::dropIfExists('place_birth_attrs');
        Schema::dropIfExists('place_births');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
