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
Route::get('/debug-ably', function () {
    try {
        // Test 1: Verificar configuración
        $connection = config('broadcasting.connections.ably');
        dump('Configuración Ably:', $connection);
        
        // Test 2: Verificar variables de entorno
        dump('ABLY_KEY:', env('ABLY_KEY'));
        dump('BROADCAST_CONNECTION:', env('BROADCAST_CONNECTION'));
        
        // Test 3: Crear mensaje fake y usar TU evento
        $fakeMessage = new \App\Models\LandbotMessage();
        $fakeMessage->id = 999;
        $fakeMessage->conversation_data = 'Test desde debug';
        $fakeMessage->author_type = 'cliente';
        $fakeMessage->conversation_id = 1;
        $fakeMessage->message_timestamp = now();
        
        // Usar TU evento
        broadcast(new \App\Events\MessageSent($fakeMessage));
        
        return 'Debug completado - evento MessageSent enviado';
        
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage() . ' en línea: ' . $e->getLine();
    }
});
require __DIR__ . '/auth.php';
