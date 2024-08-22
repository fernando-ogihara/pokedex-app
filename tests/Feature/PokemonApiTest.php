<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\PokemonService;
use Illuminate\Support\Facades\Http;

class PokemonApiTest extends TestCase
{
    public function test_get_all_pokemons()
    {
        $response = $this->get('/api/pokemons');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'pokemons',
                    'count'
                ]);

        $data = $response->json();

        // check if 'count' is greater than 0
        $this->assertIsInt($data['count']);
        $this->assertGreaterThan(0, $data['count']);
    }

    public function test_get_pokemon_by_name()
    {
        $name = 'pikachu'; // test to a pokemon name (if it's available in the API)
        $response = $this->get("/api/pokemons/{$name}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'name',
                    'image',
                    'height',
                    'weight',
                    'abilities',
                 ]);
    }

    public function test_get_pokemon_by_empty_name()
    {
        $name = ''; // empty name
        $response = $this->get("/api/pokemons/{$name}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'pokemons',
                    'count'
                ]);
    }

    public function test_get_pokemons_returns_expected_data()
    {
        // Mock the HTTP response
        Http::fake([
            'https://pokeapi.co/api/v2/pokemon' => Http::response([
                'count' => 1118,
                'results' => [
                    ['name' => 'bulbasaur'],
                    ['name' => 'ivysaur'],
                ],
            ], 200)
        ]);

        // Call the service method
        $service = new PokemonService();
        $data = $service->getPokemons();

        // Check if the data is as expected
        $this->assertCount(2, $data['pokemons']);
        $this->assertEquals(1118, $data['count']);
        $this->assertEquals('bulbasaur', $data['pokemons'][0]['name']);
    }

    public function test_get_pokemon_by_name_returns_expected_data()
    {
        // Mock the HTTP response
        Http::fake([
            'https://pokeapi.co/api/v2/pokemon/pikachu' => Http::response([
                'name' => 'pikachu',
                'sprites' => ['front_default' => 'https://example.com/pikachu.png'],
                'height' => 4,
                'weight' => 60,
                'abilities' => [
                    ['ability' => ['name' => 'static']],
                    ['ability' => ['name' => 'lightning-rod']],
                ],
            ], 200)
        ]);

        // Call the service method
        $service = new PokemonService();
        $data = $service->getPokemonByName('pikachu');

        // Check if the data is as expected
        $this->assertEquals('pikachu', $data['name']);
        $this->assertEquals('https://example.com/pikachu.png', $data['image']);
        $this->assertEquals(4, $data['height']);
        $this->assertEquals(60, $data['weight']);
        $this->assertEquals(['static', 'lightning-rod'], $data['abilities']);
    }

    public function test_get_pokemon_by_name_handles_missing_image()
    {
        // Mock the HTTP response with missing image data
        Http::fake([
            'https://pokeapi.co/api/v2/pokemon/ditto' => Http::response([
                'name' => 'ditto',
                'sprites' => [],
                'height' => 3,
                'weight' => 40,
                'abilities' => [
                    ['ability' => ['name' => 'limber']],
                    ['ability' => ['name' => 'imposter']],
                ],
            ], 200)
        ]);

        // Call the service method
        $service = new PokemonService();
        $data = $service->getPokemonByName('ditto');

        // Ensure the placeholder image is returned
        $this->assertEquals('https://via.placeholder.com/150', $data['image']);
        $this->assertEquals('ditto', $data['name']);
    }

    public function test_get_pokemon_by_name_handles_api_error()
    {
        // Mock the HTTP response with an error
        Http::fake([
            'https://pokeapi.co/api/v2/pokemon/nonexistent' => Http::response(null, 404)
        ]);

        // Call the service method
        $service = new PokemonService();
        $data = $service->getPokemonByName('nonexistent');

        // The service should handle the error gracefully
        $this->assertNull($data);
    }
}

