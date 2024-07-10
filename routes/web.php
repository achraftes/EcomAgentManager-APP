<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/leads', function () {
    return view('leads');
})->name('leads');

Route::get('/products', function () {
    return view('products');
})->name('products');

Route::get('/mediaBuyers', function () {
    return view('mediaBuyers');
})->name('mediaBuyers');

Route::get('/clients', function () {
    return view('clients');
})->name('clients');
