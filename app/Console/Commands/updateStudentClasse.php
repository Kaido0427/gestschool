<?php

namespace App\Console\Commands;

use App\Helpers\CurrentPromotion;
use App\Models\StudentClasse;
use App\Models\User;
use Illuminate\Console\Command;

class updateStudentClasse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:promotion:class';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cette commande permettra d\'enregistrer les eleves pour dans une classe pour une promotion données. ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return string
     */
    public function handle()
    {
        $users = User::where('type', 'student')->where('mclasse_id', '>', 0)->get();
        foreach ($users as $user) {

            StudentClasse::create(['user_id' => $user->id, 'mclass_id' => $user->mclasse_id, "promotion_id" => CurrentPromotion::currentPromotion()['id']]);
        }
        return 'mise à joue des étudiants avec succès';
    }
}
