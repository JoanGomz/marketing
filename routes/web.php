<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', App\Livewire\Panels\Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('/usuarios', App\Livewire\Panels\User::class)
    ->middleware(['auth', 'verified'])
    ->name('users');
Route::get('/conversaciones', App\Livewire\Panels\Conversation\ConversationHub::class)
    ->middleware(['auth', 'verified'])
    ->name('conversations');
Route::get('/parques', App\Livewire\Panels\Park::class)
    ->middleware(['auth', 'verified'])
    ->name('park');
Route::get('/clientes', App\Livewire\Panels\Client::class)
    ->middleware(['auth', 'verified'])
    ->name('client');

Route::get('/edit.profile.livewire', App\Livewire\Panels\ProfileEdit::class)
    ->middleware(['auth', 'verified'])
    ->name('edit.profile.livewire');

Route::get('/edit.password', App\Livewire\Panels\PasswordEdit::class)
    ->middleware(['auth', 'verified'])
    ->name('edit.password');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';
