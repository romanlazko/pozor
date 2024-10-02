<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'telegram:inzerko_bot'])->name('inzerko_bot.')->group(function () {
    Route::get('/page', function(){
        return view('inzerko_bot::page');
    })->name('page');
});