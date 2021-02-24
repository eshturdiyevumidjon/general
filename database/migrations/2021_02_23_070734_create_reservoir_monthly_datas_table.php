<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservoirMonthlyDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservoir_monthly_datas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('object_id')->nullable();
            $table->foreign('object_id')->references('id')->on('gvk_objects');
            $table->integer('year');
            $table->float('january_1')->nullable();
            $table->float('january_2')->nullable();
            $table->float('january_3')->nullable();
            $table->float('february_1')->nullable();
            $table->float('february_2')->nullable();
            $table->float('february_3')->nullable();
            $table->float('march_1')->nullable();
            $table->float('march_2')->nullable();
            $table->float('march_3')->nullable();
            $table->float('april_1')->nullable();
            $table->float('april_2')->nullable();
            $table->float('april_3')->nullable();
            $table->float('may_1')->nullable();
            $table->float('may_2')->nullable();
            $table->float('may_3')->nullable();
            $table->float('june_1')->nullable();
            $table->float('june_2')->nullable();
            $table->float('june_3')->nullable();
            $table->float('july_1')->nullable();
            $table->float('july_2')->nullable();
            $table->float('july_3')->nullable();
            $table->float('august_1')->nullable();
            $table->float('august_2')->nullable();
            $table->float('august_3')->nullable();
            $table->float('september_1')->nullable();
            $table->float('september_2')->nullable();
            $table->float('september_3')->nullable();
            $table->float('october_1')->nullable();
            $table->float('october_2')->nullable();
            $table->float('october_3')->nullable();
            $table->float('november_1')->nullable();
            $table->float('november_2')->nullable();
            $table->float('november_3')->nullable();
            $table->float('decamber_1')->nullable();
            $table->float('decamber_2')->nullable();
            $table->float('decamber_3')->nullable();
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
        Schema::dropIfExists('reservoir_monthly_datas');
    }
}
