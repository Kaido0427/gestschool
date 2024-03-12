<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MatiereMclassUseratnull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matiere_mclass', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable()->default(null)->change();
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
            $table->bigInteger('user_id')->unsigned()->nullable(false)->change();
        });
    }
}
