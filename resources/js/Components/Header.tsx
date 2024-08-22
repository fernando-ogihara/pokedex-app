import React from 'react';

interface HeaderProps {
    showBackButton: boolean;
    searchTerm: string;
    setSearchTerm: (term: string) => void;
    showSearch: boolean;
}

const Header: React.FC<HeaderProps> = ({ showBackButton, searchTerm, setSearchTerm, showSearch  }) => {

    return (
        <header className="bg-red-500 shadow p-4 flex justify-between items-center">
            <h1 className="text-3xl text-white font-bold"><a href='/'>POKEDEX</a></h1>
            {showBackButton && (
                    <a 
                        href='/'
                        className="border text-white rounded-lg p-2 "
                    ><span>Back to home</span>
                    </a>
                )}
            {showSearch && (
                <input
                    type="text"
                    placeholder="Search Pokémon..."
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                    className="border rounded-lg p-2 w-1/3"
                />
            )}
        </header>
    );
};

export default Header;
