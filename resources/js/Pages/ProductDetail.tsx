import React, { useState, useEffect } from 'react';
import { usePage } from '@inertiajs/inertia-react';
import Header from '../Components/Header';
import FetchApi from '@/Hooks/FetchApi';

const PokemonDetail: React.FC = () => {
    const [searchTerm, setSearchTerm] = useState('');
    const { name } = usePage().props;
    
    // Use the custom usePokemon hook
    const { pokemon, error } = FetchApi(name);

    return (
        <>
        <Header searchTerm={searchTerm} setSearchTerm={setSearchTerm} showSearch={false} showBackButton={true} />
            <main className="flex-grow flex flex-col items-center mt-6 p-4">
                {error ? (
                    <p className="text-red-500 text-xl">{error}</p>
                ) : pokemon ? (
                    <div className="bg-white shadow-md rounded-lg p-4 text-center max-w-md">
                        <img
                            src={pokemon.image}
                            alt={pokemon.name}
                            className="w-48 h-48 mx-auto mb-4"
                        />
                        <h1 className="text-3xl font-bold capitalize">{pokemon.name}</h1>
                        <p className="mt-2">Species: {pokemon.species}</p>
                        <p className="mt-2">Height: {pokemon.height} decimetres</p>
                        <p className="mt-2">Weight: {pokemon.weight} hectograms</p>
                        <p className="mt-2">Abilities: {pokemon.abilities.join(', ')}</p>
                    </div>
                ) : (
                    <p>Loading Pokemon Details...</p>
                )}
            </main>
        </>
    );
};

export default PokemonDetail;
