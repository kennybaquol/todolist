<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToDoListController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/home', function () {
    return Inertia::render('Home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/todolists/{ToDoList}', [ToDoListController::class, 'update'])->name('todolist.update');
    Route::delete('/todolists/{ToDoList}', [ToDoListController::class, 'destroy'])->name('todolist.destroy');
});

Route::fallback(function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';
