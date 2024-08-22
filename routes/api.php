<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

// Define routes for interacting with the external API
Route::get('/pokemons', [APIController::class, 'fetchPokemons']);
Route::get('/pokemons/{name}', [APIController::class, 'fetchPokemonByName']);
