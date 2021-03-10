<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGidrogeologiyaWellDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gidrogeologiya_well_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wells_type_id')->nullable();
            $table->string('type_name')->nullable();
            $table->integer('year')->nullable();
            $table->string('number_auther')->nullable();
            $table->string('cadaster_number')->nullable();
            $table->float('mineralization')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gidrogeologiya_well_data');
    }
}
