<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {

    Route::get('/', function () {
        return view('chat');
    });
    Route::get('/mensajes', [MessageController::class, 'index'])->name('messages.index');

    Route::post('/mensajes/nuevo', [MessageController::class, 'store'])->name('messages.store');
});

Auth::routes([
    'register' => false, //Para eliminar la ruta de registro
    'reset' => false, //Para eliminar la ruta de restaurar contraseña
    'verify' => false, //Para eliminar la ruta de verificación
]);

