<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BulletinController extends Controller
{
    
    public function studentBulletin(User $id)
    {
        $user = $id;

        return view('student.bulletins', compact('user'));
    }
}
