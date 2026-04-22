<?php

use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicNewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function() {
    Route::get('/admin', fn() => view('admin.index'))->name('admin.index');
    Route::get('/admin/dashboard', fn () => view('dashboard'))->name('admin.dashboard');
    Route::get('/admin/news', [NewsController::class, 'index'])->name('admin.news.index');
    Route::get('/admin/news/create', [NewsController::class, 'create'])->name('admin.news.create');
    Route::post('/admin/news', [NewsController::class, 'store'])->name('admin.news.store');
    Route::get('/admin/{id}', [NewsController::class, 'show'])->name('admin.news.show');
    Route::get('/admin/{id}/edit', [NewsController::class, 'edit'])->name('admin.news.edit');
});

Route::prefix('news')->group(function () {
    Route::get('/', [PublicNewsController::class, 'index'])->name('news.index');
    Route::get('/{slug}', [PublicNewsController::class, 'show'])->name('news.show');
});

require __DIR__.'/auth.php';
