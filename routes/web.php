<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

// Home view via React component
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

// Product detail view via React component
Route::get('/pokemons/{name}', function ($name) {
    return Inertia::render('ProductDetail', [
        'name' => $name
    ]);
})->name('product.detail');