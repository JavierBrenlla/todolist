<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 50);
            $table->string("descripcion", 500);
            $table->dateTime("fecha_creacion");
            $table->boolean("recursiva");
            $table->enum("repetir", ["d", "s", "m"])->nullable();
            $table->dateTime("fin")->nullable();
            $table->unsignedBigInteger('lista_id');
            $table->foreign('lista_id')->references('id')->on('listas');
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
        Schema::dropIfExists('tareas');
    }
}