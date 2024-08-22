<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PokemonService;

class APIController extends Controller
{
    protected $pokemonService;

    public function __construct(PokemonService $pokemonService)
    {
        $this->pokemonService = $pokemonService;
    }

    public function fetchPokemons()
    {
        $data = $this->pokemonService->getPokemons();
        return response()->json($data);
    }

    public function fetchPokemonByName($name)
    {
        $data = $this->pokemonService->getPokemonByName($name);
        return response()->json($data);
    }
}
