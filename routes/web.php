<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/contacts/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contacts.thanks');

Route::get('/admin', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/contacts/{id}', [AdminController::class, 'show'])->name('admin.show');
    Route::delete('/admin/contacts/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    Route::get('/admin/tags/{id}/edit', [TagController::class, 'edit'])->name('admin.tags.edit');
    Route::post('/admin/tags', [TagController::class, 'store'])->name('admin.tags.store');
    Route::put('/admin/tags/{id}', [TagController::class, 'update'])->name('admin.tags.update');
    Route::delete('/admin/tags/{id}', [TagController::class, 'destroy'])->name('admin.tags.destroy');
});
