import React, { useState, useEffect, ChangeEvent } from 'react';
import { Link } from '@inertiajs/react';
import Header from '../Components/Header'; 
import FetchApi from '@/Hooks/FetchApi';

// Define a type for Pokémon
interface Pokemon {
    name: string;
}

const Home: React.FC = () => {
    const {pokemons, error} = FetchApi();
    const [searchTerm, setSearchTerm] = useState<string>('');

    // Filter Pokémon based on the search term
    const filteredPokemons = pokemons?.filter(pokemon =>
        pokemon.name.toLowerCase().includes(searchTerm.toLowerCase())
    ) || [];

    return (
        <>
        <Header searchTerm={searchTerm} setSearchTerm={setSearchTerm} showSearch={true} showBackButton={false} />

        <main className="flex-grow container mx-auto mt-6 p-4 text-center">
            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                {filteredPokemons.map(pokemon => (
                    <Link
                        key={pokemon.name}
                        href={`/pokemons/${pokemon.name}`}
                        className="bg-white rounded-lg p-4 text-center block shadow-md hover:shadow-yellow-lg transition-shadow duration-300"
                    >
                        <h2 className="text-xl font-bold capitalize">{pokemon.name}</h2>
                    </Link>
                ))}
            </div>
        </main>
        </>
            
    );
};

export default Home;
