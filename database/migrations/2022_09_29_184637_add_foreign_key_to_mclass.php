<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToMclass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mclasses', function (Blueprint $table) {
            
            $table->foreignId('level_id')->constrained();
            $table->foreignId('sector_id')->constrained();

        });
    }

    /**
     * Reverse the migrations.
     * @return void
     * 
     */

    public function down()
    {
        Schema::table('mclasses', function (Blueprint $table) {

            $table->dropForeign('mclasses_level_id_foreign');
            $table->dropForeign('mclasses_sector_id_foreign');
            $table->dropIndex('mclasses_level_id_index');
            $table->dropIndex('mclasses_sector_id_index');
            $table->dropColumn('sector_id');
            $table->dropColumn('level_id');
            
        });
    }
}
