<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CapsuleController;
use App\Http\Controllers\CapsuleRecipientController;
use App\Http\Controllers\ContentController;


use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // Routes protégées
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::prefix('capsules')->group(function () {
        Route::get('/', [CapsuleController::class, 'index']);
        Route::get('/{id}', [CapsuleController::class, 'show'])->where('id', '[0-9]+');
        Route::post('/', [CapsuleController::class, 'store']);
        Route::put('/{id}', [CapsuleController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/{id}', [CapsuleController::class, 'destroy'])->where('id', '[0-9]+');
        Route::prefix('/{capsuleId}/recipients')->group(function () {
    
            Route::get('/', [CapsuleRecipientController::class, 'index'])->where('capsuleId', '[0-9]+');// Liste les destinataires d'une capsule
            Route::post('/', [CapsuleRecipientController::class, 'store'])->where('capsuleId', '[0-9]+');// Ajoute un destinataire
            Route::delete('/{recipientId}', [CapsuleRecipientController::class, 'destroy'])->where('recipientId', '[0-9]+'); // Supprime un destinataire
            });
            
    });
    Route::prefix('reactions')->controller(ReactionController::class)->group(function () {
        Route::get('/', 'index');             // Récupérer toutes les réactions
        Route::get('/{id}', 'show');          // Afficher une réaction spécifique
        Route::post('/', 'store');            // Créer une réaction
        Route::put('/{id}', 'update');        // Mettre à jour une réaction
        Route::delete('/{id}', 'destroy');    // Supprimer une réaction
    });
    
    // Routes pour les notifications
    Route::prefix('notifications')->controller(NotificationController::class)->group(function () {
        Route::get('/', 'index');             // Récupérer toutes les notifications
        Route::get('/{id}', 'show');          // Afficher une notification spécifique
        Route::post('/', 'store');            // Créer une notification
        Route::put('/{id}', 'update');        // Mettre à jour une notification
        Route::delete('/{id}', 'destroy');    // Supprimer une notification
    });
    
});



// Routes pour CapsuleController//

Route::prefix('capsules')->group(function () {
// Routes pour les destinataires d'une capsule

// Routes pour les contenus d'une capsule
Route::prefix('/{capsuleId}/contents')->group(function () {
Route::get('/', [ContentController::class, 'index'])->where('capsuleId', '[0-9]+'); // Liste le contenu d'une capsule
Route::post('/', [ContentController::class, 'store']);// Ajoute un contenu
Route::put('/{contentId}', [ContentController::class, 'update'])->where('contentId', '[0-9]+');// Met à jour un contenu
Route::delete('/{contentId}', [ContentController::class, 'destroy'])->where('contentId', '[0-9]+'); // Supprime un contenu
});
});