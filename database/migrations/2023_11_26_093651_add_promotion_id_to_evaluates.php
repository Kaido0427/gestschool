<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromotionIdToEvaluates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluates', function (Blueprint $table) {
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
        Schema::table('evaluates', function (Blueprint $table) {
            //
        });
    }
}
