<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::view('/', 'welcome');

// Route::view('/', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', \App\Livewire\Dasboards\Index::class)->name('dashboard');
    Route::get('/users', \App\Livewire\Users\Index::class)->name('users');
    Route::get('/gejala', \App\Livewire\Symptoms\Index::class)->name('gejala');
    Route::get('/diagnosa', \App\Livewire\Diagnosa\Index::class)->name('diagnosa');
    Route::get('/diagnosa_history', \App\Livewire\Diagnosa\History::class)->name('diagnosa_history');
});
require __DIR__ . '/auth.php';
