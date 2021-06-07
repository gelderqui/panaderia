<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areasucursales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idarea')->unsigned();
            $table->integer('idsucursal')->unsigned();
            $table->boolean('condicion')->default(1);
            $table->timestamps();

       
            $table->foreign('idarea')->references('id')->on('areas')->OnDelete('cascade');
            $table->foreign('idsucursal')->references('id')->on('sucursales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areasucursales');
    }
}
