<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToUes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ues', function (Blueprint $table) {
            $table->enum('type',['UE DE SPECIALITE', 'UE DE METHODOLOGIE', 'UE CULTURE GÉNÉRALE', 'UE DE CONNAISSANCES FONDAMENTALES'])->nullable();
            $table->enum('semestre',['SEMESTRE 1', 'SEMESTRE 2', 'SEMESTRE 3','SEMESTRE 4', 'SEMESTRE 5','SEMESTRE 6'])->nullable();
            $table->string('code')->nullable();
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
