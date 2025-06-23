<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('dresses', App\Http\Controllers\DressController::class);
    Route::resource('rentals', App\Http\Controllers\RentalController::class);
});
