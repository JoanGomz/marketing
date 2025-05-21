<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', App\Livewire\Panels\Dashboard::class)
    ->name('dashboard');
Route::get('/usuarios', App\Livewire\Panels\User::class)
    ->name('users');
Route::get('/roles', App\Livewire\Panels\Role::class)
    ->name('role');
Route::get('/permisos', App\Livewire\Panels\Permission::class)
    ->name('permission');
Route::get('/conversaciones', App\Livewire\Panels\Conversation\ConversationHub::class)
    ->name('conversations');
Route::get('/parques', App\Livewire\Panels\Park::class)
    ->name('park');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';
