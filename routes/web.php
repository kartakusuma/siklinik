<?php

use App\Http\Controllers\BangsalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\UserController;
use App\Models\RekamMedis;
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

Route::redirect('/', 'login');

Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'loginView');
    Route::post('login', 'login');
    Route::get('logout', 'logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [LoginController::class, 'dashboard']);

    Route::resource('users', UserController::class);
    Route::get('users-datatable', [UserController::class, 'usersDatatable']);

    Route::resource('pasiens', PasienController::class);
    Route::get('pasiens-datatable', [PasienController::class, 'pasiensDatatable']);

    Route::resource('bangsals', BangsalController::class);
    Route::get('bangsals-datatable', [BangsalController::class, 'bangsalsDatatable']);

    Route::resource('ruangs', RuangController::class);
    Route::get('ruangs-datatable', [RuangController::class, 'ruangsDatatable']);
    Route::get('ruangs-options', [RuangController::class, 'ruangsOptions']);

    Route::resource('rekam-medis', RekamMedisController::class);
    Route::get('rekam-medis-datatable', [RekamMedisController::class, 'rekamMedisDatatable']);

    Route::resource('reseps', ResepController::class);
    Route::get('reseps-datatable', [ResepController::class, 'resepsDatatable']);
    Route::patch('reseps/{id}/status', [ResepController::class, 'updateResepStatus']);
});
