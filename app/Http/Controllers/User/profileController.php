<?php

namespace App\Http\Controllers\User;

use App\Helpers\CurrentPromotion;
use App\Helpers\NextPromotion;
use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\Level;
use App\Models\Mclass;
use App\Models\StudentClasse;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class profileController extends Controller
{

    public function updatePassword(Request $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Le mot de passe saissir est incorrect");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            // Current password and new password same
            return redirect()->back()->with("error", "Le nouveau mot de passe ne doit pas être le même que l'ancien");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = $request->get('new-password');
        $user->save();

        return redirect()->back()->with("success", "Mise à jour du mot de passe effectuer");
    }

    public function showUpdatePasswordForm()
    {
        return view('user.profile.change-password');
    }

    public function activated($id)
    {

        $user = User::find($id);

        //dd($user['is_active']);
        if ($user->is_active) {
            $user->is_active = false;
        } else {
            $user->is_active = true;
        }
        $user->save();

        return redirect()->back()->with("success", "Utilisateur modifier avec succèss");
    }

    public function loginForm()
    {
        return view('student.login');
    }

    public function logout(Request $request)
    {

        Auth::logout();

        return redirect('login');
    }


    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        $checkUser = User::Where("email", $request->email)->first();

        //dd($checkUser->is_active);

        if ($checkUser && !$checkUser->is_active) {

            return redirect()->back()->with('error', 'Veuillez contactez l\'administration');
        } else
        if (FacadesAuth::attempt($credentials)) {

            if (auth()->user()->type == "admin") {

                return redirect()->intended('/');
            } elseif (auth()->user()->type == "teacher") {

                return redirect()->intended('teacher/dasboard');
            } elseif (auth()->user()->type == "personal") {

                return redirect()->intended('personal/dasboard');
            } else {

                return redirect()->intended('student/dasboard')->withSuccess('Signed in');
            }
        }

        return redirect()->back()->with('error', 'Information non-valide');
    }

    public function initPassword($id)
    {

        $user = User::find($id);

        if ($user) {

            if ($user->type == "student") {
                $user->password = 'Etudi@nt';
            }
            if ($user->type == "teacher") {
                # code...
                $user->password = 'Pr@fesseur';
            }
            if ($user->type == "personal") {

                $user->password = 'Person@l';
            }
            $user->save();
            return redirect()->back()->with("success", "Le mot de passe de $user->name a bien été réinitialisé!");
        }
    }

    public function pass($id)
    {
        $user = User::find($id);
        // Pour faire passer l'étudiant de façons manuel d'une classe à une autre 
        // je vérifie si la promotion suivante à la promotion actuelle a déjà été créer sinon je le crée
        // Je récupere la classe dont  level est superieur à son level actuel avec la même filiere
        // j'enregistre maintenant l'eleve dans la classe pour la promotion

        $userCurrentClasse = $user->studentPromotionClasses()->where('promotion_id', CurrentPromotion::currentPromotion()['id'])
            ->with('mclass', function ($query) {
                $query->with('level');
            })->first();

        $userCurrentLevel =  $userCurrentClasse['mclass']['level']['name'];

        $nexPromotion = NextPromotion::nextPromotion();
        $endLevel = explode(" ", $userCurrentLevel)[count(explode(" ", $userCurrentLevel)) - 1];

        $newLevel = mb_substr($userCurrentLevel, 0, -1) . $endLevel + 1;
        // Je récupère la liste des levels du système
        $levelNames = Level::all()->pluck('name')->toArray();

        if (in_array($newLevel, $levelNames)) {
            $level = Level::where('name', $newLevel)->first();
            $classe = Mclass::where('level_id', $level['id'])->where('sector_id', $userCurrentClasse['mclass']['sector']['id'])->first();

            $searchStudent = StudentClasse::where('user_id', $user['id'])
                ->where('promotion_id', $nexPromotion['id'])
                ->first();

            if (!$searchStudent) {

                StudentClasse::Create(['user_id' => $user['id'], 'promotion_id' => $nexPromotion['id'], 'mclass_id' => $classe['id']]);
            } else {

                return redirect()->back()->with("error", "L'etudiant  $user->firstname $user->name a déjà été affecté  à une classe pour l'année prochaine !");
            }
        }
        return redirect()->back()->with("success", "Le passage en classe supérieur de $user->firstname $user->name est effectué avec succès !");
    }

    public function fail($id)
    {
        $user = User::find($id);
        // Pour faire passer l'étudiant de façons manuel d'une classe à une autre 
        // je vérifie si la promotion suivante à la promotion actuelle a déjà été créer sinon je le crée
        // Je récupere la classe dont  level est superieur à son level actuel avec la même filiere
        // j'enregistre maintenant l'eleve dans la classe pour la promotion

        $userCurrentClasse = $user->studentPromotionClasses()->where('promotion_id', CurrentPromotion::currentPromotion()['id'])
            ->with('mclass', function ($query) {
                $query->with('level');
            })->first();

        $userCurrentLevel =  $userCurrentClasse['mclass']['level']['name'];

        $nexPromotion = NextPromotion::nextPromotion();

        $newLevel = $userCurrentLevel;
        // Je récupère la liste des levels du système
        $levelNames = Level::all()->pluck('name')->toArray();

        if (in_array($newLevel, $levelNames)) {
            $level = Level::where('name', $newLevel)->first();
            $classe = Mclass::where('level_id', $level['id'])->where('sector_id', $userCurrentClasse['mclass']['sector']['id'])->first();
            $searchStudent = StudentClasse::where('user_id', $user['id'])
                ->where('promotion_id', $nexPromotion['id'])
                ->first();

            if (!$searchStudent) {

                StudentClasse::Create(['user_id' => $user['id'], 'promotion_id' => $nexPromotion['id'], 'mclass_id' => $classe['id']]);
            } else {

                return redirect()->back()->with("error", "L'etudiant  $user->firstname $user->name a déjà été affecté  à une classe pour l'année prochaine !");
            }
        }
        return redirect()->back()->with("success", "L'etudiant  $user->firstname $user->name est enregistré dans la même classe pour l'année prochaine !");
    }
    public function profile($id)
    {
        $user = User::find($id);
        $image = Avatar::where("user_id", $id)->first();
        return view('student.profile', compact('image', 'user'));
    }
}
