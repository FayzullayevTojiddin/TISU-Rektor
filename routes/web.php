<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use SergiX44\Nutgram\Nutgram;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/messages', [MessageController::class, 'index'])->name('admin.messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('admin.messages.show');
    Route::post('/messages/{message}/reply', [MessageController::class, 'reply'])->name('admin.messages.reply');
});

Route::post('/{token}/webhook', function (Nutgram $bot, string $token) {
    if ($token !== config('nutgram.token')) {
        abort(404);
    }
    $bot->run();
})->where('token', '.*');
