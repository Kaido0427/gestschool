<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MatiereSemestre extends Migration
{
    public function up()
    {
        Schema::create('matiere_semestre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matiere_id');
            $table->foreignId('semestre_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matiere_semestre');
    }
}
