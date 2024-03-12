<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromotionToMatiereMclass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matiere_mclass', function (Blueprint $table) {

            $table->unsignedBigInteger('promotion_id')->nullable();

            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
            
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
