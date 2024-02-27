<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Geo\GeoController;

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


// Route to display the login form
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Route to handle the login request
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    // Route to display the edit profile form
    Route::get('/profile', [LoginController::class, 'showLoginForm'])->name('profile');

    // Route to handle the profile request
    Route::post('/profile', [LoginController::class, 'login']);

    Route::resource('/geo-fence', GeoController::class);

    // Route
    Route::post('/geo-status-change/{item}', [GeoController::class, 'updateStatus'])->name('geo-fence.updateStatus');

});