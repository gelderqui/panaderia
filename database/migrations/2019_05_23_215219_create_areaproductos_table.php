<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaproductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areaproductos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idarea')->unsigned();
            $table->integer('idproducto')->unsigned();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
       
            $table->foreign('idarea')->references('id')->on('areas')->OnDelete('cascade');
            $table->foreign('idproducto')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areaproductos');
    }
}
