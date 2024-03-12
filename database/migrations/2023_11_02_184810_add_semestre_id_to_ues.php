<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSemestreIdToUes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ues', function (Blueprint $table) {
            
            $table->unsignedBigInteger('semestre_id')->nullable();
            $table->foreign('semestre_id')->references('id')->on('semestres')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ues', function (Blueprint $table) {
            //
        });
    }
}
