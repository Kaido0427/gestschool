<?php

namespace App\Console\Commands;

use App\Helpers\CurrentPromotion;
use App\Models\Mclass;
use App\Models\StudentClasse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class createOrUpdateStudent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:or:update:student';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $datas = json_decode(file_get_contents(storage_path() . "/students.json"), true);

        foreach ($datas as $student) {

            $checkStudentExisted = User::where('email', $student['Email'])->first();

            dump($student);
            if ($checkStudentExisted) {
                $checkStudentExisted->birth_place = array_key_exists('Lieu de Naissance', $student) ? $student['Lieu de Naissance'] : null;
                $checkStudentExisted->birth_day = array_key_exists('Date de Naissance', $student) ? Carbon::createFromFormat('d/m/Y', $student['Date de Naissance'])->format('Y-m-d') : null;
                $checkStudentExisted->nationality =  $student['NATIONALITE'];

                $checkStudentExisted->save();
            }
        }
        return 0;
    }
}
