<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MatiereUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Sélectionner les enregistrements en double et les regrouper par nom et par UE
        $duplicates = DB::table('matieres')
            ->select('name', 'ue_id')
            ->selectRaw('MIN(id) as min_id')
            ->groupBy('name', 'ue_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        // Boucle sur les enregistrements en double
        foreach ($duplicates as $duplicate) {
            // Sélectionner tous les enregistrements en double sauf le plus petit ID
            $duplicateRecords = DB::table('matieres')
                ->where('name', $duplicate->name)
                ->where('ue_id', $duplicate->ue_id)
                ->where('id', '!=', $duplicate->min_id)
                ->pluck('id');

            // Supprimer les enregistrements en double
            DB::table('matieres')
                ->whereIn('id', $duplicateRecords)
                ->delete();
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
