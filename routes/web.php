<?php

use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\MessageController;
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
    // Dashboard
    Route::get('/', fn() => view('admin.index'))->name('index');

    // News Management
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/create', [NewsController::class, 'create'])->name('create');
        Route::post('/', [NewsController::class, 'store'])->name('store');
        Route::get('/{news}', [NewsController::class, 'show'])->name('show');
        Route::get('/{news}/edit', [NewsController::class, 'edit'])->name('edit');
        Route::put('/{news}', [NewsController::class, 'update'])->name('update');
        Route::delete('/{news}', [NewsController::class, 'destroy'])->name('destroy');
        Route::delete('/{news}/remove-thumbnail', [NewsController::class, 'removeThumbnail'])->name('remove-thumbnail');
    });

    // Archive Management
    Route::prefix('archive')->name('archive.')->group(function () {
        Route::get('/', [ArchiveController::class, 'index'])->name('index');
        Route::get('/create', [ArchiveController::class, 'create'])->name('create');
        Route::post('/', [ArchiveController::class, 'store'])->name('store');
        Route::get('/{archive}', [ArchiveController::class, 'show'])->name('show');
        Route::get('/{archive}/edit', [ArchiveController::class, 'edit'])->name('edit');
        Route::put('/{archive}', [ArchiveController::class, 'update'])->name('update');
        Route::delete('/{archive}', [ArchiveController::class, 'destroy'])->name('destroy');
    });

    // Messages Management
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::patch('/{message}/mark-as-read', [MessageController::class, 'markAsRead'])->name('mark-as-read');
        Route::post('/reply', [MessageController::class, 'reply'])->name('reply');
    });

    // Services
    Route::get('/services', fn() => view('admin.services.index'))->name('services.index');
});

Route::get('/news', [PublicNewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [PublicNewsController::class, 'show'])->name('news.show');

Route::get('/archives', [PublicArchiveController::class, 'index'])->name('archives.index');
Route::get('/archives/{archive}', [PublicArchiveController::class, 'show'])->name('archives.show');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

require __DIR__ . '/auth.php';
