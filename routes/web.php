<?php

use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isStudent;
use App\Http\Middleware\isTeacher;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Information\InformationController;
use App\Http\Controllers\Statistique\statistiqueController;
use App\Http\Controllers\Synopsis\synopsisController;
use App\Http\Controllers\Personal\Personalcontroller;
use App\Http\Controllers\Note\NoteController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\MclassController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\Student\BulletinController;
use App\Http\Controllers\UeController;
use App\Http\Controllers\Semestre\SemestreController;

use App\Http\Controllers\DateImportantController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| 
*/


Route::middleware([isStudent::class])->group(function () {
    Route::get('student/dasboard', [StudentController::class, 'dashboard'])->name('student.dasboard');
    Route::get('student-course-programme', [StudentController::class, 'programme'])->name('classe.emploie');
    Route::get('student-course-list', [StudentController::class, 'matieres'])->name('student.classe.matiere');
    Route::get('classe/{id}/programme', [StudentController::class, 'programme']);
    Route::get('profile-image', [StudentController::class, 'profilImage'])->name('profil.image');
    Route::get('student-carte/{id}', [StudentController::class, 'myCarte'])->name('student.mycarte');
    Route::get('/class-synopsis', [synopsisController::class, 'classSynopsis'])->name('class.synopsis');

    Route::get('bulletins', [StudentController::class, 'bulletin'])->name('bulletin.of.student');
    // http://127.0.0.1:8000/student/promotion/2023-2024/bulletins/
    Route::get("/bulletin/{promotion}/{semestre}", [StudentController::class, 'showMyBulletins'])->name('showBulletin');
    Route::get("/bulletin/promotion/{promotion}/semestre/{semestre}", [StudentController::class, 'myBulletins'])->name('student.bulletin');
    Route::get("/bulletin/canonic/promotion/{promotion}/semestre/{semestre}", [StudentController::class, 'myBulletinsCanonic'])->name('student.bulletin.canonic');
});

Route::middleware([isTeacher::class])->group(function () {
    Route::get('teacher/dasboard', [TeacherController::class, 'dashboard'])->name('teacher.dasboard');
    Route::get('teacher/{teacher}/matiere/{matiere}/classe/{classe}/students', [TeacherController::class, 'students']);
    Route::get('teacher/classe', [TeacherController::class, 'classes'])->name('teacher.classe');
    Route::post('note', [NoteController::class, 'store'])->name('note.store');
    Route::patch('/addSyllabus/classe/{classe}/matiere/{id}',[TeacherController::class,'addSyllabus'])->name('addSyllabus');
    Route::get('/editSyllabus/classe/{classe}',[TeacherController::class,'editSyllabus'])->name('edit.Syllabus');

    Route::get('classe/{classe}/matiere/{matiere}/student/{matricule}', [NoteController::class, 'create'])->name('classe.data');
});

Route::get('teacher/signup', [TeacherController::class, 'signUp'])->name('teacher.signup');
Route::post('teacher/signup', [TeacherController::class, 'save'])->name('teacher.save');
Route::get('student-login', [App\Http\Controllers\User\profileController::class, 'loginForm'])->name('student.connexion');

Route::post('student-inscription', [StudentController::class, 'save'])->name('student.save');

Route::get('student-inscription', [StudentController::class, 'inscrire'])->name('student.account');

Route::get('login', [App\Http\Controllers\User\profileController::class, 'loginForm'])->name('login');

Route::get('logout', [App\Http\Controllers\User\profileController::class, 'logout'])->name('logout');

Route::post('login', [App\Http\Controllers\User\profileController::class, 'login'])->name('user.login');

Route::post('/authlog', [AdminAuthController::class, 'postLogin'])->name('auth.login');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/changePassword', [App\Http\Controllers\User\profileController::class, 'showUpdatePasswordForm'])->name('changePasswordGet');
    Route::post('/user/{id}/init-password', [App\Http\Controllers\User\profileController::class, 'initPassword'])->name('initPassword');
    Route::get('/students/{id}/profil', [App\Http\Controllers\User\profileController::class, 'profile']);
    Route::post('/changePassword', [App\Http\Controllers\User\profileController::class, 'updatePassword'])->name('changePasswordPost');
    Route::get('student/{id}/notes', [StudentController::class, 'dashboard']);
    Route::get('/student/{id}/bulletins', [BulletinController::class, 'studentBulletin']);
    Route::get('/add-profile/images/{id}', [StudentController::class, 'addAvatar'])->name('addProfil');
    route::get('student/{id}/carte', [StudentController::class, 'studentCarte'])->name('student.carte');
    route::get('download/students/{id}/carte', [StudentController::class, 'downloadCarte'])->name('download');
    Route::resource('informations', InformationController::class);
    Route::post('add-profile-image/{id}', [StudentController::class, 'addProfil'])->name('addingProfil');
});

Route::middleware([isAdmin::class])->group(function () {

    Route::resource('promotions', PromotionController::class);
    Route::resource('levels', LevelController::class);
    Route::resource('sectors', SectorController::class);
    Route::resource('classes', MclassController::class);
    Route::resource('matieres', MatiereController::class);
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('dateimportants', DateImportantController::class);

    Route::resource('personals', Personalcontroller::class);
    Route::resource('ues', UeController::class);
    Route::resource('semestres', SemestreController::class);

    Route::get('classe/{id}/matieres', [MclassController::class, 'matieres'])->name('matieres-classe');
    Route::get('classe/{id}/add-matiere', [MclassController::class, 'showAddMatieresForm']);
    Route::post('classe/add-time-usage', [MclassController::class, 'addFile']);
    Route::get('classe/{id}/add-time-usage', [MclassController::class, 'showAddFile']);
    Route::get('classe/{id}/students', [MclassController::class, 'students']);
    Route::get('classe/{id}/ed', [MclassController::class, 'modified'])->name('classMat.edit');
    Route::get('classe/{id}/edit', [MclassController::class, 'edit'])->name('class.edit');

    Route::post('classe', [MatiereController::class, 'classeData'])->name('classe.matiere');
    Route::put('classe/{id}', [MatiereController::class, 'updateClasseData'])->name('classe.update');

    Route::post('user/{id}/desactivate', [App\Http\Controllers\User\profileController::class, 'activated']);
    Route::post('user/{id}/pass', [App\Http\Controllers\User\profileController::class, 'pass']);
    Route::post('user/{id}/fail', [App\Http\Controllers\User\profileController::class, 'fail']);

    Route::get('/', [statistiqueController::class, 'showStat'])->name('admin.dashboard');
    Route::get('delete/matiere/{matiere}/to-classe/{classe}', [MatiereController::class, 'deleteMatiereToClass'])->name('delete.matiere.to.class');
    Route::get('/synopsis', [synopsisController::class, 'index'])->name('add.synopsis');
    Route::delete('/matiere/{matiere}/in-classe/{classe}', [MclassController::class, 'deleteMatiere'])->name('delete.classe.matiere');

    Route::get('bulletins/{id}', [StudentController::class, 'bulletin'])->name('bulletin');
    Route::get("/promotion/{promotion}/student/{user}/bulletins/{semestre}", [StudentController::class, 'studentBulletin'])->name('student-bulletin');
    Route::get("/promotion/{promotion}/student/{user}/bulletins/canonic/{semestre}", [StudentController::class, 'studentBulletinCanonique'])->name('student-bulletin-canonique');
    Route::get('/ues/{ue}/semestres/{mat}', [UeController::class, 'semestres'])->name('getSemestresByUE');

});
