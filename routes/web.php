<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\ClientController as ControllersClientController;
use App\Http\Controllers\UserController;
use Laravel\Passport\Http\Controllers\ClientController;

Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');


Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
    Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
    Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/oauth/clients', [ControllersClientController::class, 'store'])->name('client.store');

    Route::get('/client-edit/{id}', [ControllersClientController::class, 'edit'])->name('client.edit');
    Route::get('/client-delete/{id}', [ControllersClientController::class, 'destroy'])->name('client.delete');
    Route::post('/client-update/{id}', [ControllersClientController::class, 'update'])->name('update');

    Route::post('/user/create', [UserController::class, 'store'])->name('user.create');
    Route::get('/user-edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::get('/user-delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::post('/user-update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/{page}', [PageController::class, 'index'])->name('page');
});
