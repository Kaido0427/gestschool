<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSyllabusAttributeToMatieres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matiere_mclass', function (Blueprint $table) {
            $table->string('syllabus')->nullable();
            $table->foreignId('user_id')->constrained()->nullable(true);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matiere_mclass', function (Blueprint $table) {
            //
        });
    }
}
