<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('post')->controller(PostController::class)->name('post.')->group(function() {
    Route::get('', 'index')->name('index');
    Route::get('create', 'create')->name('create')->middleware('auth');
    Route::post('', 'store')->name('store')->middleware('auth');
    Route::get('{post}', 'show')->whereNumber('post')->name('show');
    Route::get('{post}/edit', 'edit')->whereNumber('post')->name('edit')->middleware('auth');
    Route::put('{post}', 'update')->whereNumber('post')->name('update')->middleware('auth');
    Route::delete('{post}', 'destroy')->whereNumber('post')->middleware('auth')->name('destroy');
});

require __DIR__.'/auth.php';
