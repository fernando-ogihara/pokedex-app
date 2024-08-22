import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/inertia-react';
import Layout from './Layout/Layout';

createInertiaApp({
    resolve: name => import(`./Pages/${name}`).then(module => module.default),
    setup({ el, App, props }) {
        const root = createRoot(el);  // Create root
        root.render(
            <Layout>
                <App {...props} />
            </Layout>
        );
    },
});
