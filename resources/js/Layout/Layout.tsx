import React from 'react';
import Footer from '../Components/Footer'; // Adjust the import path as necessary

const Layout: React.FC<{ children: React.ReactNode }> = ({ children }) => {
    return (
        <div className="min-h-screen flex flex-col">
            <main>{children}</main>
            <Footer />
        </div>
    );
};

export default Layout;
