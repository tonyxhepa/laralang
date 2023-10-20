<?php

use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Localization;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/localization/{locale}', LocalizationController::class)->name('localization');

Route::middleware(Localization::class)
    ->group(function () {

        Route::get('/', function () {
            $count = User::count();
            return view('welcome', compact('count'));
        });

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        require __DIR__ . '/auth.php';
    });
