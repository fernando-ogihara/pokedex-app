import { useState, useEffect } from 'react';

function FetchApi(name?: string) {
    const [pokemon, setPokemon] = useState(null);
    const [pokemons, setPokemons] = useState(null);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const fetchPokemon = async () => {
            try {
                let response;
                if (name) {
                    // Fetch a single Pokémon by name
                    response = await fetch(`/api/pokemons/${name}`);
                } else {
                    // Fetch all Pokémon
                    response = await fetch(`/api/pokemons`);
                }

                if (!response.ok) {
                    throw new Error(name ? 'Pokémon not found' : 'Error - Network response was not ok');
                }

                const data = await response.json();

                if (name) {
                    if (Object.keys(data).length === 0) {
                        throw new Error('Pokémon not found');
                    }
                    setPokemon(data);
                } else {
                    setPokemons(data.pokemons);
                }

                setError(null);
            } catch (error) {
                console.error('Failed to fetch Pokémon(s):', error);
                if (name) {
                    setPokemon(null);
                    setError('Pokémon not found');
                } else {
                    setPokemons(null);
                    setError('Failed to fetch Pokémon list');
                }
            }
        };

        fetchPokemon();
    }, [name]);

    return { pokemon, pokemons, error };
}

export default FetchApi;
