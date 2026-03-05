<?php

use Illuminate\Support\Facades\Route;
use SergiX44\Nutgram\Nutgram;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/{token}/webhook', function (Nutgram $bot, string $token) {
    if ($token !== config('nutgram.token')) {
        abort(404);
    }
    $bot->run();
})->where('token', '.*');
