<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnuaireController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// admin controller
Route::post('adminregister', [AdminController::class, 'adminregister'])->name('adminregister');
Route::post('adminlog', [AdminController::class, 'adminlog'])->name('adminlog');

Route::view('adminlog', 'Admin/login')->name('adminlog');
Route::group(['middleware' => 'admin:admin-api'], function () {
    Route::post('adminlogout', [AdminController::class, 'adminlogout'])->name('adminlogout');
    Route::post('me',[AdminController::class,  'me']);
});

//user controller
Route::post('userregister', [UserController::class, 'userregister'])->name('userregister');
Route::post('userlog', [UserController::class, 'userlog'])->name('userlog');

Route::group(['middleware' => 'auth:user-api'], function () {
    Route::post('userlogout', [Usercontroller::class, 'userlogout'])->name('userlogout');
    Route::post('userme',[Usercontroller::class,  'me']);
});


//crud annuaire par un administrateur
Route::get('annuaire/create', [AnnuaireController::class, 'create']);//ajout annuaire
// Route::put('annuaire/update/{annuaire}', [AnnuaireController::class, 'update']);//modifier annuaire
// Route::delete('annuaire/{simplon}', [AnnuaireController::class, 'delete']);//supprimmer annuaire