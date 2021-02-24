<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRejimGidropostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rejim_gidropost', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('station_id')->nullable();
            $table->foreign('station_id')->references('id')->on('stations');
            $table->integer('year')->nullable();
            $table->unsignedBigInteger('parameter_id')->nullable();
            $table->foreign('parameter_id')->references('id')->on('gidromet_parameters');
            $table->float('january')->nullable();
            $table->float('february')->nullable();
            $table->float('march')->nullable();
            $table->float('april')->nullable();
            $table->float('may')->nullable();
            $table->float('june')->nullable();
            $table->float('july')->nullable();
            $table->float('august')->nullable();
            $table->float('september')->nullable();
            $table->float('october')->nullable();
            $table->float('november')->nullable();
            $table->float('decamber')->nullable();
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
        Schema::dropIfExists('rejim_gidropost');
    }
}
