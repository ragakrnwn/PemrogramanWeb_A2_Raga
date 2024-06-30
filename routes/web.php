<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepanController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\PengaturanHalamanController;
use App\Http\Controllers\ProfileController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/', [DepanController::class, "index"]);
Route::redirect('home', 'dashboard');
Route::get('/auth', [AuthController::class, "index"])->name('login')->middleware('guest');
Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});
Route::group(['middleware' => ['web']], function () {
    Route::get('/auth/redirect', function () {
        return Socialite::driver('google')->redirect();
    });
});
Route::get('/auth/callback', function () {
    $user = Socialite::driver('google')->stateless()->user();
    $id = $user->id;
    $email = $user->email;
    $name = $user->name;
    return "$id - $email - $name";
});
Route::get('/auth/logout', [AuthController::class, "logout"]);
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth');
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [HalamanController::class, 'index']);
    Route::resource('halaman', HalamanController::class);
    Route::resource('experience', ExperienceController::class);
    Route::resource('education', EducationController::class);
    Route::get('skill', [SkillController::class, "index"])->name('skill.index');
    Route::post('skill', [SkillController::class, "update"])->name('skill.update');
    Route::get('profile', [ProfileController::class, "index"])->name('profile.index');
    Route::post('profile', [ProfileController::class, "update"])->name('profile.update');
    Route::get('pengaturanhalaman', [PengaturanHalamanController::class, "index"])->name('pengaturanhalaman.index');
    Route::post('pengaturanhalaman', [PengaturanHalamanController::class, "update"])->name('pengaturanhalaman.update');
});
