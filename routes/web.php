<?php

declare(strict_types=1);

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\StepController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/ideas');

Route::middleware('auth')->group(function () {
    Route::get('/ideas', [IdeaController::class, 'index'])->name('idea.index');
    Route::get('/ideas/{idea}', [IdeaController::class, 'show']);
    Route::post('/ideas', [IdeaController::class, 'store'])->name('idea.store');
    Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy']);

    Route::post('/logout', [SessionsController::class, 'destroy']);
    Route::patch('/steps/{step}', [StepController::class, 'update'])->name('step.update');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store']);

});
