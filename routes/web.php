<?php

use Illuminate\Support\Facades\Route;
use SergiX44\Nutgram\Nutgram;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/' . env('TELEGRAM_TOKEN') . '/webhook', function (Nutgram $bot) {
    $bot->run();
});
