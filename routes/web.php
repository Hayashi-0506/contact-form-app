<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin', fn () => '管理者画面（準備中）')->name('admin.index');
});
