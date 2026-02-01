<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\PollController;

Route::get('/results/{id}', [VoteController::class, 'results']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/polls', [PollController::class, 'index']);
    Route::get('/poll/{id}', [PollController::class, 'show']);
    Route::post('/vote', [VoteController::class, 'vote']);
    Route::get('/results/{id}', [VoteController::class, 'results']);
    

});


require __DIR__.'/auth.php';
