<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BienController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\AnnuaireController;
use App\Http\Controllers\RessourceController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\EspaceDialogueController;

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
// Route::post('adminregister', [AdminController::class, 'adminregister'])->name('adminregister');
// Route::post('adminlog', [AdminController::class, 'adminlog'])->name('adminlog');

// Route::view('adminlog', 'Admin/login')->name('adminlog');
// Route::group(['middleware' => 'admin:admin-api'], function () {
//     Route::post('adminlogout', [AdminController::class, 'adminlogout'])->name('adminlogout');
//     Route::post('me',[AdminController::class,  'me']);
// });

//user controller
Route::post('userregister', [UserController::class, 'userregister'])->name('userregister');
Route::post('userlog', [UserController::class, 'userlog'])->name('userlog');
Route::group(['middleware' => 'auth:user-api'], function () {
    Route::post('userme',[Usercontroller::class,  'me']);
    Route::post('userlogout', [Usercontroller::class, 'userlogout'])->name('userlogout');
});
   //Verification email
Route::post('verifMail',[UserController::class,'verifMail']);
Route::post('resetPassword/{user}',[UserController::class,'resetPassword']);
 




//crud annuaire par un administrateur
Route::post('annuaire/create', [AnnuaireController::class, 'create']);//ajout annuaire
Route::put('annuaire/update/{annuaire}', [AnnuaireController::class, 'update']);//modifier annuaire
Route::delete('annuaire/{annuaire}', [AnnuaireController::class, 'delete']);//supprimmer annuaire
Route::get('listes_annuaires', [AnnuaireController::class,'index']); // listes des annuaires


//crud produit par un utilisateur
Route::post('produit/create', [ProduitController::class, 'create']);//ajout produit
Route::put('produit/update/{produit}', [ProduitController::class, 'update']);//modifier produit
Route::delete('delete/{produit}', [ProduitController::class, 'delete']);//supprimmer produit
Route::get('listes_produit', [ProduitController::class,'index']); // listes des produit

//crud bien par un utilisateur
Route::post('bien/create', [BienController::class, 'create']);//ajout bien
Route::delete('delete/{bien}', [BienController::class, 'delete']);//supprimmer bien
Route::get('listes_bien', [BienController::class,'index']); // listes des bien
Route::put('bien/update/{bien}', [BienController::class, 'update']);//modifier bien


//crud annonce par un administrateur
Route::post('annonce/create', [AnnonceController::class, 'create']);//ajout annonce
Route::put('annonce/update/{annonce}', [AnnonceController::class, 'update']);//modifier annonce
Route::delete('annonce/{annonce}', [AnnonceController::class, 'delete']);//supprimmer annonce
Route::get('liste_annonce', [AnnonceController::class,'index']); // listes des annonces

//crud Ressource par un administrateur
Route::post('ressource/create', [RessourceController::class, 'create']);//ajout ressource
Route::put('ressource/update/{ressource}', [RessourceController::class, 'update']);//modifier ressource
Route::delete('deleteRessource/{ressource}', [RessourceController::class, 'delete']);//supprimmer ressource
Route::get('liste_ressource', [RessourceController::class,'index']); // listes des ressources

//crud commentaire par un utilisateur
Route::post('commentaire/create', [CommentaireController::class, 'create']);//ajout commentaire
Route::put('commentaire/update/{commentaire}', [CommentaireController::class, 'update']);//modifier commentaire
Route::delete('deleteCommentaire/{commentaire}', [CommentaireController::class, 'delete']);//supprimmer commentaire
Route::get('liste_commentaire', [CommentaireController::class,'index']); // listes des commentaires

//crud discussion dans espace dialogue par un utilisateur
Route::post('discussion/create', [EspaceDialogueController::class, 'create']);//ajout discussion
Route::put('discussion/update/{discussion}', [EspaceDialogueController::class, 'update']);//modifier discussion
Route::delete('deleteDiscussion/{discussion}', [EspaceDialogueController::class, 'delete']);//supprimmer discussion
Route::get('liste_discussion', [EspaceDialogueController::class,'index']); // listes des discussions
