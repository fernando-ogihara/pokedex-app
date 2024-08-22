<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PokemonService
{
    public function getPokemons(): array
    {
        $response = Http::get('https://pokeapi.co/api/v2/pokemon');
        $data = $response->json();

        return [
            'pokemons' => array_map(fn($pokemon) => ['name' => $pokemon['name']], $data['results']),
            'count' => $data['count']
        ];
    }

    public function getPokemonByName($name): ?array
    {
        $response = Http::get('https://pokeapi.co/api/v2/pokemon/' . $name);
        
        if ($response->successful()) {
            $data = $response->json();

            return [
                'name' => $data['name'],
                'image' => $data['sprites']['front_default'] ?? 'https://via.placeholder.com/150',
                'height' => $data['height'],
                'weight' => $data['weight'],
                'abilities' => array_map(fn($ability) => $ability['ability']['name'], $data['abilities']),
            ];
        }

        // Handle error case, returning null
        return null;
    }
}