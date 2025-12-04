<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

use App\Http\Controllers\MovieController;
Route::resource('movies', MovieController::class);

// Localized route for 'filmes.listar'
Route::get('/filmes', [MovieController::class, 'index'])->name('filmes.listar');
Route::get('/filmes/adicionar', [MovieController::class, 'create'])->name('filmes.criar');
Route::post('/movies/reorder', [MovieController::class, 'reorder'])->name('movies.reorder');
