<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritosTable extends Migration
{
    public function up()
    {
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('propiedad_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('propiedad_id')->references('id')->on('propiedads')->onDelete('cascade');

            $table->unique(['user_id', 'propiedad_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favoritos');
    }
}