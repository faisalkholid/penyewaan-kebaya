<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('laporan/excel', [App\Http\Controllers\HomeController::class, 'exportExcel'])->name('laporan.excel');

Route::middleware(['auth'])->group(function () {
    Route::resource('dresses', App\Http\Controllers\DressController::class);
    Route::resource('rentals', App\Http\Controllers\RentalController::class);
});

Route::get('/sewa', function () {
    $dresses = \App\Models\Dress::where('status', 'tersedia')->where('stock', '>', 0)->get();
    return view('rentals.public_create', compact('dresses'));
})->name('public.rental.create');
Route::post('/sewa', [App\Http\Controllers\RentalController::class, 'store'])->name('public.rental.store');
Route::get('/sewa/{rental}', function ($rentalId) {
    $rental = \App\Models\Rental::findOrFail($rentalId);
    return view('rentals.public_show', compact('rental'));
})->name('public.rental.show');
