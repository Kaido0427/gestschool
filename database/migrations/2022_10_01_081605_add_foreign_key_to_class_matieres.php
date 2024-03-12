<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToClassMatieres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matiere_mclass', function (Blueprint $table) {
            
            $table->foreignId('mclass_id')->constrained()->nullable(true);
            $table->foreignId('matiere_id')->constrained()->nullable(true);

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
            
            $table->dropForeign('matiere_mclass_mclass_id_foreign');
            $table->dropForeign('matiere_mclass_matiere_id_foreign');
            $table->dropIndex('matiere_mclass_mclass_id_index');
            $table->dropIndex('matiere_mclass_matiere_id_index');
            $table->dropColumn('matiere_id');
            $table->dropColumn('mclass_id');

        });
    }
}
