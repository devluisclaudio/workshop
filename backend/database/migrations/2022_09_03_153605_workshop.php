<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();

            $table->integer('grupo_id');
            $table->integer('sexo');
            $table->integer('idade');
            $table->integer('estado_civil_id');

            $table->string('nome');
            $table->string('celular');
            $table->string('nome_lider_gr');
            $table->string('email');


            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workshops');
    }
};
