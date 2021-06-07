<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idclase')->unsigned();
            $table->string('nombre',50)->unique();
            $table->string('codigo',50)->unique();
            $table->decimal('costo',11,2);
            $table->decimal('preciosucursal',11,2);
            $table->decimal('preciofranquicia',11,2);
            $table->boolean('condiciontemporada')->default(1);
            $table->boolean('condicion')->default(1);
            $table->timestamps();

            $table->foreign('idclase')->references('id')->on('clases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
