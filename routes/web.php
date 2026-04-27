<?php

use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicArchiveController;
use App\Http\Controllers\PublicNewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => view('admin.index'))->name('index');
    Route::resource('news', NewsController::class);
    Route::resource('archive', ArchiveController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
});

Route::get('/news', [PublicNewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [PublicNewsController::class, 'show'])->name('news.show');

Route::get('/archives', [PublicArchiveController::class, 'index'])->name('archives.index');
Route::get('/archives/{archive}', [PublicArchiveController::class, 'show'])->name('archives.show');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

require __DIR__ . '/auth.php';
